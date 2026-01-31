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
        // 1. Bersihkan Nomor HP (08xx -> 628xx) dan pastikan hanya angka
        $target = $this->normalizePhoneNumber($to);

        // Quick validation
        if (empty($target) || !preg_match('/^[0-9]{8,15}$/', $target)) {
            Log::warning("WhatsApp GAGAL: Nomor tujuan tidak valid atau sangat pendek: {$to} -> normalized: {$target}");
            return null;
        }

        // 2. Ambil Token dari .env
        $token = env('WHATSAPP_API_TOKEN');

        if (empty($token)) {
            Log::error("WhatsApp GAGAL: Token WHATSAPP_API_TOKEN belum diisi di file .env");
            return null;
        }

        // 3. Kirim Request ke Fonnte
        try {
            $payload = [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ];

            // Log before sending (debug)
            Log::info("Mencoba kirim WA ke: {$target}");
            Log::debug('WA payload: ' . json_encode($payload));

            // Jangan kirim URL gambar jika masih di localhost, karena Fonnte akan menolaknya.
            if ($fileUrl && !str_contains($fileUrl, 'localhost') && !str_contains($fileUrl, '127.0.0.1')) {
                 $payload['url'] = $fileUrl;
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', $payload);

            // Log status and body for easier debugging
            $statusCode = method_exists($response, 'status') ? $response->status() : 'no-status';
            $body = method_exists($response, 'body') ? $response->body() : null;
            Log::info("WA HTTP status: {$statusCode}");
            Log::debug("WA Response body: " . ($body ?? 'NULL'));

            // Cek apakah berhasil
            if (method_exists($response, 'successful') && $response->successful()) {
                Log::info("WA Terkirim ke {$target}: " . ($body ?? 'no-body'));
            } else {
                Log::error("Gagal kirim WA. Status: {$statusCode}. Body: " . ($body ?? 'NULL'));
                Log::error("WA Gagal ke {$target}. Response: " . ($body ?? 'NULL'));
            }

            // Return response so callers (jobs) can act/log on it
            return $response;

        } catch (\Exception $e) {
            Log::error("Error Koneksi WhatsApp: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Public wrapper to normalize phone numbers for Jobs/Logs
     */
    public function formatPhoneNumber(string $number): string
    {
        return $this->normalizePhoneNumber($number);
    }

    /**
     * Normalize phone numbers to international format without symbols.
     * - Ubah awalan '08' menjadi '628'
     * - Hapus spasi, tanda '-' dan non-digit lain
     * - Jika dimulai dengan '8' (misal kirim tanpa 0), tambahkan '62'
     */
    private function normalizePhoneNumber($number)
    {
        $number = (string) $number;
        // Hapus semua non angka
        $number = preg_replace('/[^0-9]/', '', $number);

        // Ubah awalan '08' jadi '628'
        if (str_starts_with($number, '08')) {
            $number = '628' . substr($number, 2);
            return $number;
        }

        // Jika dimulai dengan '0' tapi bukan '08' (misal 021...), ganti '0' -> '62'
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
            return $number;
        }

        // Jika dimulai langsung dengan '8' (tanpa 0), tambahkan '62'
        if (str_starts_with($number, '8')) {
            $number = '62' . $number;
            return $number;
        }

        // Jika sudah berformat '62...' atau lain, kembalikan apa adanya
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

        return $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }
}