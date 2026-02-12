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
     * Handle the Kunjungan "updated" event.
     */
    public function updated(Kunjungan $kunjungan): void
    {
        // 1. Cek apakah kolom 'status' benar-benar berubah
        if (!$kunjungan->wasChanged('status')) {
            return;
        }

        $status = $kunjungan->status;
        $channel = $kunjungan->preferred_notification_channel ?? 'both'; // 'email', 'whatsapp', or 'both'

        // Inisialisasi log notifikasi
        $logs = $kunjungan->notification_logs ?? [];
        $newLog = [
            'timestamp' => now()->toDateTimeString(),
            'status_at_time' => $status->value,
            'email' => !empty($kunjungan->email_pengunjung) ? 'pending' : 'skipped',
            'whatsapp' => !empty($kunjungan->no_wa_pengunjung) ? 'pending' : 'skipped',
        ];
        
        // Simpan log (kita simpan log terbaru di awal array atau tumpuk)
        $logs[] = $newLog;
        
        // Update tanpa memicu observer lagi
        $kunjungan->notification_logs = $logs;
        $kunjungan->saveQuietly();

        Log::info("Kunjungan ID: {$kunjungan->id} status updated to {$status->value}. Channel: {$channel}");

        // =========================================================================
        // KONDISI A: STATUS SELESAI (COMPLETED)
        // Aksi: Kirim Link Survey (Email) & Ucapan Terima Kasih (WA)
        // =========================================================================
        if ($status === KunjunganStatus::COMPLETED) {

            // 1. Kirim Notifikasi Survey via Email (WAJIB jika ada email)
            if (!empty($kunjungan->email_pengunjung)) {
                try {
                    // Menggunakan $kunjungan->notify() agar variabel $notifiable di SendSurveyLink terbaca
                    // Pastikan model Kunjungan menggunakan trait 'Notifiable'
                    $kunjungan->notify(new SendSurveyLink());
                    Log::info("Survey notification sent for Kunjungan ID: {$kunjungan->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to send survey notification for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                }
            }

            // 2. Kirim Pesan WA Selesai (Jika user memilih WA/Both)
            if (in_array($channel, ['whatsapp', 'both'])) {
                try {
                    SendWhatsAppCompletedNotification::dispatch($kunjungan);
                    Log::info("WA Completed job dispatched for Kunjungan ID: {$kunjungan->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to dispatch WA Completed for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                }
            }

            // PENTING: Return di sini agar tidak lanjut ke blok Approved/Rejected di bawah
            return;
        }

        // =========================================================================
        // KONDISI B: STATUS DISETUJUI (APPROVED) ATAU DITOLAK (REJECTED)
        // Aksi: Kirim Tiket/Info Status (Email) & Notifikasi Status (WA)
        // =========================================================================
        if (in_array($status, [KunjunganStatus::APPROVED, KunjunganStatus::REJECTED])) {

            // Persiapan File QR Code (Hanya ada jika Approved)
            $qrPath = null;
            $qrUrl  = null;

            if ($status === KunjunganStatus::APPROVED) {
                // Cek apakah file QR ada di storage public
                if (Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.png")) {
                    $qrPath = Storage::disk('public')->path("qrcodes/{$kunjungan->id}.png");
                    $qrUrl  = Storage::disk('public')->url("qrcodes/{$kunjungan->id}.png");
                } elseif (Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.svg")) {
                    $qrPath = Storage::disk('public')->path("qrcodes/{$kunjungan->id}.svg");
                    $qrUrl  = Storage::disk('public')->url("qrcodes/{$kunjungan->id}.svg");
                }
            }

            // 1. Kirim Email Status (KunjunganStatusMail)
            if (in_array($channel, ['email', 'both'])) {
                if (!empty($kunjungan->email_pengunjung)) {
                    try {
                        Mail::to($kunjungan->email_pengunjung)
                            ->queue(new KunjunganStatusMail($kunjungan, $qrPath));

                        $kunjungan->updateNotificationLog('email', 'sent');
                        Log::info("Email status ({$status->value}) queued for Kunjungan ID: {$kunjungan->id}");
                    } catch (\Exception $e) {
                        $kunjungan->updateNotificationLog('email', 'failed', $e->getMessage());
                        Log::error("Failed to queue email status for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                    }
                }
            }

            // 2. Kirim WhatsApp Status
            if (in_array($channel, ['whatsapp', 'both'])) {
                try {
                    if ($status === KunjunganStatus::APPROVED) {
                        SendWhatsAppApprovedNotification::dispatch($kunjungan, $qrUrl);
                    } elseif ($status === KunjunganStatus::REJECTED) {
                        SendWhatsAppRejectedNotification::dispatch($kunjungan);
                    }

                    Log::info("WhatsApp status ({$status->value}) job dispatched for Kunjungan ID: {$kunjungan->id}");
                } catch (\Exception $e) {
                    $kunjungan->updateNotificationLog('whatsapp', 'failed', $e->getMessage());
                    Log::error("Failed to dispatch WA status for Kunjungan ID: {$kunjungan->id}. Error: " . $e->getMessage());
                }
            }
        }
    }
}
