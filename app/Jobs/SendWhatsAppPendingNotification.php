<?php

namespace App\Jobs;

use App\Models\Kunjungan;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppPendingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kunjungan;
    protected $qrCodeUrl;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Kunjungan $kunjungan
     * @param string $qrCodeUrl
     */
    public function __construct(Kunjungan $kunjungan, string $qrCodeUrl)
    {
        $this->kunjungan = $kunjungan;
        $this->qrCodeUrl = $qrCodeUrl;
    }

    public $tries = 5;

    public function backoff(): array
    {
        return [60, 120, 300, 900];
    }

    /**
     * Execute the job.
     *
     * @param \App\Services\WhatsAppService $whatsAppService
     * @return void
     * @throws \Exception
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        $original = $this->kunjungan->no_wa_pengunjung;
        Log::info("PendingJob: Preparing to send WA for Kunjungan ID: {$this->kunjungan->id}, original: {$original}");

        $normalized = $whatsAppService->formatPhoneNumber($original);
        Log::info("PendingJob: Normalized WA number: {$normalized}");

        $response = $whatsAppService->sendPending($this->kunjungan, $this->qrCodeUrl);

        $ok = false;
        $reason = null;
        $requestId = null;
        if ($response && method_exists($response, 'body')) {
            $body = $response->body();
            $decoded = json_decode($body, true) ?: [];
            $ok = (!array_key_exists('status', $decoded) || $decoded['status'] === true) && (method_exists($response, 'successful') ? $response->successful() : true);
            $reason = $decoded['reason'] ?? null;
            $requestId = $decoded['requestid'] ?? null;
        }

        if ($ok) {
            \Illuminate\Support\Facades\Cache::forget("wa_failures:{$normalized}");
            Log::info("PendingJob: WA sent for Kunjungan ID: {$this->kunjungan->id}. Response: " . ($response ? $response->body() : 'no response'));
            return;
        }

        $key = "wa_failures:{$normalized}";
        $count = (int) (\Illuminate\Support\Facades\Cache::get($key, 0) + 1);
        \Illuminate\Support\Facades\Cache::put($key, $count, 60 * 60);

        $threshold = 3;
        if ($count < $threshold) {
            Log::warning("PendingJob: WA provider rejected for Kunjungan ID: {$this->kunjungan->id}. Attempt {$count}/{$threshold}. Reason: " . ($reason ?? 'unknown') . ". RequestId: " . ($requestId ?? 'n/a'));
            throw new \Exception('WA provider rejected: ' . ($reason ?? 'unknown'));
        }

        $alertKey = "wa_alerted:{$normalized}";
        if (!\Illuminate\Support\Facades\Cache::get($alertKey)) {
            try {
                \Illuminate\Support\Facades\Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\WhatsAppProviderFailure([
                    'kunjungan_id' => $this->kunjungan->id,
                    'target' => $normalized,
                    'original' => $original,
                    'reason' => $reason,
                    'requestid' => $requestId,
                    'response' => $response ? ($response->body() ?? null) : null,
                    'attempts' => $count,
                ]));
                \Illuminate\Support\Facades\Cache::put($alertKey, true, 24 * 60 * 60);
                Log::error("PendingJob: Admin alerted for repeated WA failures for target {$normalized} (Kunjungan ID: {$this->kunjungan->id}). Attempts: {$count}");
            } catch (\Exception $e) {
                Log::error("PendingJob: Failed to send admin alert for Kunjungan ID: {$this->kunjungan->id}. Error: " . $e->getMessage());
            }
        }

        Log::error("PendingJob: WA FAILED repeatedly for Kunjungan ID: {$this->kunjungan->id}. Attempts: {$count}. Reason: " . ($reason ?? 'unknown'));
        $this->fail(new \Exception('Repeated WA provider rejection: ' . ($reason ?? 'unknown')));
    }
}
