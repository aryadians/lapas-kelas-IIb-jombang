<?php

namespace App\Observers;

use App\Models\Kunjungan;
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
        if ($kunjungan->wasChanged('status') && $kunjungan->status === 'completed') {
            try {
                $kunjungan->notify(new SendSurveyLink());
                Log::info("Survey notification sent for Kunjungan ID: {$kunjungan->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send survey notification for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
            }
        }
    }
}
