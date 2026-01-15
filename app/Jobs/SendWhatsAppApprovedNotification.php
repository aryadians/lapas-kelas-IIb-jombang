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

class SendWhatsAppApprovedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kunjungan;
    protected $qrCodeUrl;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Kunjungan $kunjungan
     * @param string|null $qrCodeUrl
     */
    public function __construct(Kunjungan $kunjungan, ?string $qrCodeUrl)
    {
        $this->kunjungan = $kunjungan;
        $this->qrCodeUrl = $qrCodeUrl;
    }

    /**
     * Execute the job.
     *
     * @param \App\Services\WhatsAppService $whatsAppService
     * @return void
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        try {
            $whatsAppService->sendApproved($this->kunjungan, $this->qrCodeUrl);
            Log::info("Successfully sent approved WhatsApp notification for Kunjungan ID: {$this->kunjungan->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send approved WhatsApp notification for Kunjungan ID: {$this->kunjungan->id}. Error: " . $e->getMessage());
        }
    }
}
