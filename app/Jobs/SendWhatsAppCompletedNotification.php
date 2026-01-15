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

class SendWhatsAppCompletedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kunjungan;

    /**
     * Create a new job instance.
     */
    public function __construct(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        if (empty($this->kunjungan->no_wa_pengunjung)) {
            Log::warning("Kunjungan ID: {$this->kunjungan->id} has no WhatsApp number to send completion notification.");
            return;
        }

        try {
            $whatsAppService->sendCompleted($this->kunjungan);
            Log::info("Completion WhatsApp sent for Kunjungan ID: {$this->kunjungan->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send completion WhatsApp for Kunjungan ID: {$this->kunjungan->id}. Error: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
