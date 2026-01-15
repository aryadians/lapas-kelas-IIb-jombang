<?php

namespace App\Observers;

use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use App\Jobs\SendWhatsAppCompletedNotification;
use App\Notifications\SendSurveyLink;
use Illuminate\Support\Facades\Log;

class KunjunganObserver
{
    /**
     * Handle the Kunjungan "updated" event.
     */
    public function updated(Kunjungan $kunjungan): void
    {
        // Check if the status was changed to 'completed'
        if ($kunjungan->wasChanged('status') && $kunjungan->status === KunjunganStatus::COMPLETED) {
            // Send Survey Link Notification
            try {
                $kunjungan->notify(new SendSurveyLink());
                Log::info("Survey notification sent for Kunjungan ID: {$kunjungan->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send survey notification for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
            }

            // Send WhatsApp Completion Notification
            if ($kunjungan->preferred_notification_channel === 'whatsapp') {
                try {
                    SendWhatsAppCompletedNotification::dispatch($kunjungan);
                    Log::info("WhatsApp completion notification job dispatched for Kunjungan ID: {$kunjungan->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to dispatch WhatsApp completion notification for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                }
            }
        }
    }
}
