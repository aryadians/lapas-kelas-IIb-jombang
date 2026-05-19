<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Kunjungan;
use App\Models\VisitSetting;
use Carbon\Carbon;

class WhatsAppService
{
    /**
     * Mengirim pesan asli ke API Fonnte.
     */
    public function sendMessage(string $to, string $message, ?string $fileUrl = null)
    {
        // 1. Bersihkan Nomor HP (08xx -> 628xx) dan pastikan hanya angka
        $target = $this->normalizePhoneNumber($to);

        // Quick validation
        if (empty($target) || !preg_match('/^[0-9]{8,15}$/', $target)) {
            Log::warning("WhatsApp GAGAL: Nomor tujuan tidak valid atau sangat pendek: {$to} -> normalized: {$target}");
            return null;
        }

        // 2. Ambil Token dari Database (prioritas) atau .env (fallback)
        $token = VisitSetting::where('key', 'api_token_fonnte')->value('value');
        if (empty($token)) {
            $token = env('WHATSAPP_API_TOKEN');
        }

        if (empty($token)) {
            Log::error("WhatsApp GAGAL: Token API Fonnte belum diisi di Pengaturan Admin maupun file .env");
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
        $statusUrl = route('kunjungan.status', $kunjungan->id);
        $wbpCode = strtoupper($kunjungan->wbp->kode_tahanan ?? '');
        $isTahanan = str_starts_with($wbpCode, 'A');
        $isNarapidana = str_starts_with($wbpCode, 'B');
        $antrian = (int) $kunjungan->nomor_antrian_harian;
        
        $kategoriKunjungan = "Pendaftaran Kunjungan";
        if ($isTahanan) $kategoriKunjungan = "Pendaftaran Kunjungan Tahanan";
        elseif ($isNarapidana) $kategoriKunjungan = "Pendaftaran Kunjungan Narapidana";

        // Tentukan Jam Kedatangan
        $jamDatang = "";
        if ($antrian >= 1 && $antrian <= 60) {
            $jamDatang = "08:30 - 09:00 WIB";
        } elseif ($antrian >= 61 && $antrian <= 120) {
            $jamDatang = "09:00 - 09:30 WIB";
        } elseif ($antrian >= 121 && $antrian <= 200) {
            $jamDatang = "09:30 - 10:00 WIB";
        }
        
        $message = "*{$kategoriKunjungan} BERHASIL* ⏳\n\n"
                 . "Halo {$kunjungan->nama_pengunjung},\n"
                 . "Pendaftaran kunjungan Anda telah kami terima dan sedang dalam antrian verifikasi.\n\n"
                 . "📋 Kode: *{$kunjungan->kode_kunjungan}*\n"
                 . "📅 Tanggal: {$tanggal}\n"
                 . "🕒 Sesi: " . ucfirst($kunjungan->sesi) . "\n"
                 . "🔢 Nomor Antrian: *{$kunjungan->nomor_antrian_harian}*\n"
                 . "⏰ Estimasi Jam: *{$jamDatang}*\n"
                 . "👤 WBP: " . ($kunjungan->wbp->nama ?? '-') . "\n\n"
                 . "⚠️ *INFO PENTING:* ⚠️\n"
                 . "1. Wajib membawa *KTP ASLI* saat berkunjung.\n";

        if ($isTahanan) {
            $message .= "2. *WAJIB membawa SURAT IZIN dari pihak Penahan* (Kepolisian/Kejaksaan/Pengadilan).\n";
        }

        $message .= "3. Jumlah pengikut maksimal *4 orang* dan bisa dikunjungi *satu kali*.\n\n"
                 . "Lihat Status Lengkap: {$statusUrl}\n\n"
                 . "Simpan pesan ini sebagai bukti pendaftaran sementara.";

        // Kirim pesan
        return $this->sendMessage($kunjungan->no_wa_pengunjung, $message, $qrCodeUrl);
    }

    public function sendApproved(Kunjungan $kunjungan, ?string $qrCodeUrl = null)
    {
        $tanggal = Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y');
        $statusUrl = route('kunjungan.status', $kunjungan->id);
        $wbpCode = strtoupper($kunjungan->wbp->kode_tahanan ?? '');
        $isTahanan = str_starts_with($wbpCode, 'A');
        $isNarapidana = str_starts_with($wbpCode, 'B');
        $antrian = (int) $kunjungan->nomor_antrian_harian;
        
        $kategoriKunjungan = "Kunjungan";
        if ($isTahanan) $kategoriKunjungan = "Kunjungan Tahanan";
        elseif ($isNarapidana) $kategoriKunjungan = "Kunjungan Narapidana";

        // Tentukan Jam Kedatangan
        $jamDatang = "";
        if ($antrian >= 1 && $antrian <= 60) {
            $jamDatang = "08:30 - 09:00 WIB";
        } elseif ($antrian >= 61 && $antrian <= 120) {
            $jamDatang = "09:00 - 09:30 WIB";
        } elseif ($antrian >= 121 && $antrian <= 200) {
            $jamDatang = "09:30 - 10:00 WIB";
        }

        $message = "*{$kategoriKunjungan} DISETUJUI* ✅\n\n"
                 . "Halo {$kunjungan->nama_pengunjung},\n"
                 . "Pendaftaran Anda telah *DISETUJUI*.\n\n"
                 . "📅 Tanggal: {$tanggal}\n"
                 . "🕒 Sesi: " . ucfirst($kunjungan->sesi) . "\n"
                 . "🔢 Antrian: *{$kunjungan->nomor_antrian_harian}*\n"
                 . "⏰ Jam Kedatangan: *{$jamDatang}*\n\n"
                 . "Mohon datang tepat waktu sesuai jam kedatangan di atas.\n\n"
                 . "⚠️ *WAJIB DIBAWA:* ⚠️\n"
                 . "1. *KTP ASLI* dan atau kartu identitas resmi lainnya.\n";
        
        if ($isTahanan) {
            $message .= "2. *WAJIB membawa SURAT IZIN dari pihak Penahan* (Kepolisian/Kejaksaan/Pengadilan).\n";
        }

        $message .= "3. 1 nomor antrian hanya untuk 1 WBP, maksimal *4 orang pengikut*, dan bisa dikunjungi *satu kali*.\n\n"
                 . "Lihat Tiket QR: {$statusUrl}\n\n"
                 . "Tunjukkan QR Code di atas kepada petugas saat tiba di Lapas.";

        return $this->sendMessage($kunjungan->no_wa_pengunjung, $message, $qrCodeUrl);
    }

    public function sendRejected(Kunjungan $kunjungan)
    {
        $tanggal = Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y');
        $statusUrl = route('kunjungan.status', $kunjungan->id);
        $wbpCode = strtoupper($kunjungan->wbp->kode_tahanan ?? '');
        $isTahanan = str_starts_with($wbpCode, 'A');
        $isNarapidana = str_starts_with($wbpCode, 'B');
        
        $kategoriKunjungan = "Pendaftaran Kunjungan";
        if ($isTahanan) $kategoriKunjungan = "Pendaftaran Kunjungan Tahanan";
        elseif ($isNarapidana) $kategoriKunjungan = "Pendaftaran Kunjungan Narapidana";

        $message = "*{$kategoriKunjungan} DITOLAK* ❌\n\n"
                 . "Mohon maaf {$kunjungan->nama_pengunjung},\n"
                 . "Pendaftaran kunjungan Anda untuk tanggal " . $tanggal . " tidak dapat kami proses.\n\n"
                 . "Cek alasan penolakan di: {$statusUrl}\n\n"
                 . "Silakan hubungi petugas untuk informasi lebih lanjut.";

        return $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }
    /**
     * Kirim notifikasi bahwa kunjungan telah selesai.
     */
    public function sendCompleted(Kunjungan $kunjungan)
    {
        $tanggal = Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y');
        // Ganti ke link survei IKM Kemenimipas
        $surveyUrl = 'https://star-survei3a.kemenimipas.go.id/ly/8ITXJREv';
        $wbpCode = strtoupper($kunjungan->wbp->kode_tahanan ?? '');
        $isTahanan = str_starts_with($wbpCode, 'A');
        $isNarapidana = str_starts_with($wbpCode, 'B');
        
        $kategoriKunjungan = "Kunjungan";
        if ($isTahanan) $kategoriKunjungan = "Kunjungan Tahanan";
        elseif ($isNarapidana) $kategoriKunjungan = "Kunjungan Narapidana";

        $message = "*{$kategoriKunjungan} SELESAI* 🏁\n\n"
                 . "Halo {$kunjungan->nama_pengunjung},\n"
                 . "Kunjungan Anda pada tanggal {$tanggal} telah tercatat sebagai *SELESAI*.\n\n"
                 . "Untuk meningkatkan kualitas layanan kami, mohon kesediaan Anda untuk mengisi Survei Kepuasan Masyarakat (IKM) melalui link berikut:\n{$surveyUrl}\n\n"
                 . "Terima kasih telah mematuhi tata tertib Lapas Kelas IIB Jombang. Hati-hati di jalan.\n\n"
                 . "_Pesan ini dikirim otomatis oleh sistem._";

        return $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }

    /**
     * Kirim notifikasi pengingat H-1.
     */
    public function sendReminder(Kunjungan $kunjungan)
    {
        $tanggal = Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y');
        $statusUrl = route('kunjungan.status', $kunjungan->id);
        $wbpCode = strtoupper($kunjungan->wbp->kode_tahanan ?? '');
        $isTahanan = str_starts_with($wbpCode, 'A');
        $isNarapidana = str_starts_with($wbpCode, 'B');
        $antrian = (int) $kunjungan->nomor_antrian_harian;
        
        $kategoriKunjungan = "Kunjungan";
        if ($isTahanan) $kategoriKunjungan = "Kunjungan Tahanan";
        elseif ($isNarapidana) $kategoriKunjungan = "Kunjungan Narapidana";

        // Tentukan Jam Kedatangan
        $jamDatang = "";
        if ($antrian >= 1 && $antrian <= 60) {
            $jamDatang = "08:30 - 09:00 WIB";
        } elseif ($antrian >= 61 && $antrian <= 120) {
            $jamDatang = "09:00 - 09:30 WIB";
        } elseif ($antrian >= 121 && $antrian <= 200) {
            $jamDatang = "09:30 - 10:00 WIB";
        }

        $message = "*PENGINGAT {$kategoriKunjungan}* 🔔\n\n"
                 . "Halo {$kunjungan->nama_pengunjung},\n"
                 . "Mengingatkan bahwa jadwal kunjungan Anda adalah *BESOK*.\n\n"
                 . "📅 Tanggal: {$tanggal}\n"
                 . "🕒 Sesi: " . ucfirst($kunjungan->sesi) . "\n"
                 . "🔢 Antrian: *{$kunjungan->nomor_antrian_harian}*\n"
                 . "⏰ Jam Kedatangan: *{$jamDatang}*\n\n"
                 . "⚠️ *WAJIB DIBAWA:* ⚠️\n"
                 . "1. *KTP ASLI* / Kartu Identitas Resmi.\n";

        if ($isTahanan) {
            $message .= "2. *SURAT IZIN dari pihak Penahan* (Wajib).\n";
        }

        $message .= "Mohon datang tepat waktu dan tunjukkan kode QR pada tiket ini:\n{$statusUrl}\n\n"
                 . "Terima kasih.";

        return $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }
}