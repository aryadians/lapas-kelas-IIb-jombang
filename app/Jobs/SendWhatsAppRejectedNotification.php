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

class SendWhatsAppRejectedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kunjungan;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Kunjungan $kunjungan
     */
    public function __construct(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
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
            $whatsAppService->sendRejected($this->kunjungan);
            Log::info("Successfully sent rejected WhatsApp notification for Kunjungan ID: {$this->kunjungan->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send rejected WhatsApp notification for Kunjungan ID: {$this->kunjungan->id}. Error: " . $e->getMessage());
        }
    }
}
