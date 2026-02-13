<?php

namespace App\Observers;

use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use App\Mail\KunjunganStatusMail;
use App\Notifications\SendSurveyLink;
use App\Jobs\SendWhatsAppApprovedNotification;
use App\Jobs\SendWhatsAppRejectedNotification;
use App\Jobs\SendWhatsAppCompletedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class KunjunganObserver
{
    /**
     * Handle the Kunjungan "created" event.
     */
    public function created(Kunjungan $kunjungan): void
    {
        // Inisialisasi log pertama saat pendaftaran (Status: Pending)
        $this->initializeNotificationLog($kunjungan);
        
        Log::info("Kunjungan ID: {$kunjungan->id} created. Notification log initialized.");
    }

    /**
     * Handle the Kunjungan "updated" event.
     */
    public function updated(Kunjungan $kunjungan): void
    {
        // 1. Cek apakah kolom 'status' benar-benar berubah
        if (!$kunjungan->wasChanged('status')) {
            return;
        }

        // Tambahkan log baru untuk perubahan status ini
        $this->initializeNotificationLog($kunjungan);

        $status = $kunjungan->status;
        $channel = $kunjungan->preferred_notification_channel ?? 'both';

        Log::info("Kunjungan ID: {$kunjungan->id} status updated to {$status->value}. Channel: {$channel}");

        // =========================================================================
        // KONDISI A: STATUS SELESAI (COMPLETED)
        // =========================================================================
        if ($status === KunjunganStatus::COMPLETED) {
            if (!empty($kunjungan->email_pengunjung)) {
                try {
                    $kunjungan->notify(new SendSurveyLink());
                    $kunjungan->updateNotificationLog('email', 'sent');
                } catch (\Exception $e) {
                    $kunjungan->updateNotificationLog('email', 'failed', $e->getMessage());
                    Log::error("Failed survey email ID: {$kunjungan->id}: " . $e->getMessage());
                }
            }

            if (in_array($channel, ['whatsapp', 'both'])) {
                try {
                    SendWhatsAppCompletedNotification::dispatch($kunjungan);
                } catch (\Exception $e) {
                    $kunjungan->updateNotificationLog('whatsapp', 'failed', $e->getMessage());
                }
            }
            return;
        }

        // =========================================================================
        // KONDISI B: STATUS DISETUJUI (APPROVED) ATAU DITOLAK (REJECTED)
        // =========================================================================
        if (in_array($status, [KunjunganStatus::APPROVED, KunjunganStatus::REJECTED])) {
            $qrPath = null;
            $qrUrl  = null;

            if ($status === KunjunganStatus::APPROVED) {
                if (Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.png")) {
                    $qrPath = Storage::disk('public')->path("qrcodes/{$kunjungan->id}.png");
                    $qrUrl  = Storage::disk('public')->url("qrcodes/{$kunjungan->id}.png");
                }
            }

            // 1. Email
            if (in_array($channel, ['email', 'both']) && !empty($kunjungan->email_pengunjung)) {
                try {
                    Mail::to($kunjungan->email_pengunjung)->queue(new KunjunganStatusMail($kunjungan, $qrPath));
                    $kunjungan->updateNotificationLog('email', 'sent');
                } catch (\Exception $e) {
                    $kunjungan->updateNotificationLog('email', 'failed', $e->getMessage());
                }
            }

            // 2. WhatsApp
            if (in_array($channel, ['whatsapp', 'both'])) {
                try {
                    if ($status === KunjunganStatus::APPROVED) {
                        SendWhatsAppApprovedNotification::dispatch($kunjungan, $qrUrl);
                    } else {
                        SendWhatsAppRejectedNotification::dispatch($kunjungan);
                    }
                } catch (\Exception $e) {
                    $kunjungan->updateNotificationLog('whatsapp', 'failed', $e->getMessage());
                }
            }
        }
    }

    /**
     * Membuat entri log notifikasi baru.
     */
    private function initializeNotificationLog(Kunjungan $kunjungan): void
    {
        $logs = $kunjungan->notification_logs ?? [];
        
        $newLog = [
            'timestamp' => now()->toDateTimeString(),
            'status_at_time' => $kunjungan->status->value ?? 'pending',
            'email' => !empty($kunjungan->email_pengunjung) ? 'pending' : 'skipped',
            'whatsapp' => !empty($kunjungan->no_wa_pengunjung) ? 'pending' : 'skipped',
        ];
        
        $logs[] = $newLog;
        
        // Simpan langsung ke DB untuk menghindari masalah race condition dengan Job
        \DB::table('kunjungans')->where('id', $kunjungan->id)->update([
            'notification_logs' => json_encode($logs)
        ]);
        
        // Refresh model agar instance yang sedang jalan punya data logs terbaru
        $kunjungan->notification_logs = $logs;
    }
}
