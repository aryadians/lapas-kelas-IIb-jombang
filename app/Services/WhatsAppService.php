<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Kunjungan;
use Carbon\Carbon;

class WhatsAppService
{
    /**
     * Mengirim pesan asli ke API Fonnte.
     */
    protected function sendMessage(string $to, string $message, ?string $fileUrl = null)
    {
        // 1. Bersihkan Nomor HP (08xx -> 628xx)
        $target = $this->normalizePhoneNumber($to);

        // 2. Ambil Token dari .env
        $token = env('WHATSAPP_API_TOKEN');

        if (empty($token)) {
            Log::error("WhatsApp GAGAL: Token WHATSAPP_API_TOKEN belum diisi di file .env");
            return;
        }

        // 3. Kirim Request ke Fonnte
        try {
            $payload = [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ];

            // [MODIFIKASI SEMENTARA]
            // Jangan kirim URL gambar jika masih di localhost, karena Fonnte akan menolaknya.
            // Kita matikan fitur kirim gambar sementara agar pesan teks tetap masuk.
            if ($fileUrl && !str_contains($fileUrl, 'localhost') && !str_contains($fileUrl, '127.0.0.1')) {
                 $payload['url'] = $fileUrl;
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', $payload);

            // Cek apakah berhasil
            if ($response->successful()) {
                Log::info("WA Terkirim ke $target: " . $response->body());
            } else {
                Log::error("WA Gagal ke $target. Response: " . $response->body());
            }

        } catch (\Exception $e) {
            Log::error("Error Koneksi WhatsApp: " . $e->getMessage());
        }
    }

    /**
     * Ubah 08xxx jadi 628xxx
     */
    private function normalizePhoneNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number); // Hapus spasi/strip
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        return $number;
    }

    // --- TEMPLATE PESAN ---

    public function sendPending(Kunjungan $kunjungan, string $qrCodeUrl)
    {
        $tanggal = Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y');
        
        $message = "*PENDAFTARAN BERHASIL* ⏳\n\n"
                 . "Halo {$kunjungan->nama_pengunjung},\n"
                 . "Pendaftaran kunjungan Anda telah kami terima.\n\n"
                 . "📋 Kode: *{$kunjungan->kode_kunjungan}*\n"
                 . "📅 Tanggal: {$tanggal}\n"
                 . "🕒 Sesi: " . ucfirst($kunjungan->sesi) . "\n"
                 . "👤 WBP: " . ($kunjungan->wbp->nama ?? '-') . "\n\n"
                 . "Mohon tunggu verifikasi petugas. Kami akan mengabari Anda jika status berubah.";

        // Kirim pesan (QR Code akan diabaikan otomatis oleh logika di atas jika localhost)
        $this->sendMessage($kunjungan->no_wa_pengunjung, $message, $qrCodeUrl);
    }

    public function sendApproved(Kunjungan $kunjungan, ?string $qrCodeUrl = null)
    {
        $tanggal = Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y');

        $message = "*KUNJUNGAN DISETUJUI* ✅\n\n"
                 . "Halo {$kunjungan->nama_pengunjung},\n"
                 . "Pendaftaran Anda telah *DISETUJUI*.\n\n"
                 . "📅 Tanggal: {$tanggal}\n"
                 . "🕒 Sesi: " . ucfirst($kunjungan->sesi) . "\n"
                 . "🔢 Antrian: *{$kunjungan->nomor_antrian_harian}*\n\n"
                 . "Harap datang tepat waktu dengan membawa KTP Asli dan Bukti QR Code (Cek Email Anda untuk QR Code).";

        $this->sendMessage($kunjungan->no_wa_pengunjung, $message, $qrCodeUrl);
    }

    public function sendRejected(Kunjungan $kunjungan)
    {
        $message = "*KUNJUNGAN DITOLAK* ❌\n\n"
                 . "Mohon maaf {$kunjungan->nama_pengunjung},\n"
                 . "Pendaftaran kunjungan Anda untuk tanggal " . $kunjungan->tanggal_kunjungan . " tidak dapat kami proses.\n\n"
                 . "Silakan hubungi petugas untuk informasi lebih lanjut.";

        $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }
}