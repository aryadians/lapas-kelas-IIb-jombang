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
        // Only proceed if status really changed
        if (!$kunjungan->wasChanged('status')) {
            return;
        }

        $status = $kunjungan->status;
        $channel = $kunjungan->preferred_notification_channel ?? 'both'; // 'email', 'whatsapp', or 'both'

        // 1) Jika COMPLETED -> Kirim Survey (selalu dikirim)
        if ($status === KunjunganStatus::COMPLETED) {
            try {
                $kunjungan->notify(new SendSurveyLink());
                Log::info("Survey notification sent for Kunjungan ID: {$kunjungan->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send survey notification for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
            }
        }

        // 2) Untuk status APPROVED, REJECTED, COMPLETED -> kirim notifikasi sesuai preferensi
        if (in_array($status, [KunjunganStatus::APPROVED, KunjunganStatus::REJECTED, KunjunganStatus::COMPLETED], true)) {

            // Cari QR Code (jika ada) untuk Email dan WA (beberapa job menerima URL)
            $qrRelative = null;
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.png")) {
                $qrRelative = 'qrcodes/' . $kunjungan->id . '.png';
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.svg")) {
                $qrRelative = 'qrcodes/' . $kunjungan->id . '.svg';
            }

            $qrUrl = $qrRelative ? \Illuminate\Support\Facades\Storage::disk('public')->url($qrRelative) : null;
            $qrPath = $qrRelative ? \Illuminate\Support\Facades\Storage::disk('public')->path($qrRelative) : null;

            // EMAIL
            if (in_array($channel, ['email', 'both'], true)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($kunjungan->email_pengunjung)->queue(new \App\Mail\KunjunganStatusMail($kunjungan, $qrPath));
                    Log::info("Email status notification queued for Kunjungan ID: {$kunjungan->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to queue email for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                }
            }

            // WHATSAPP
            if (in_array($channel, ['whatsapp', 'both'], true)) {
                try {
                    switch ($status) {
                        case KunjunganStatus::APPROVED:
                            \App\Jobs\SendWhatsAppApprovedNotification::dispatch($kunjungan, $qrUrl);
                            break;

                        case KunjunganStatus::REJECTED:
                            \App\Jobs\SendWhatsAppRejectedNotification::dispatch($kunjungan);
                            break;

                        case KunjunganStatus::COMPLETED:
                            \App\Jobs\SendWhatsAppCompletedNotification::dispatch($kunjungan);
                            break;
                    }

                    Log::info("WhatsApp job dispatched for Kunjungan ID: {$kunjungan->id}, channel: {$channel}");
                } catch (\Exception $e) {
                    Log::error("Failed to dispatch WhatsApp job for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                }
            }
        }
    }
}
