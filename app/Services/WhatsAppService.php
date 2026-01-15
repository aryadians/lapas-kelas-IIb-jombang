<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Kunjungan;

class WhatsAppService
{
    /**
     * Simulates sending a WhatsApp notification.
     * In a real application, this would make an HTTP call to a WhatsApp API provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     */
    protected function sendMessage(string $to, string $message)
    {
        // Format the phone number if necessary (e.g., remove leading +, add country code)
        $formattedTo = preg_replace('/[^0-9]/', '', $to);

        // Log the message for simulation purposes.
        // In a real app, replace this with your WhatsApp API provider's SDK or HTTP client.
        Log::info("--- SIMULATING WHATSAPP MESSAGE ---");
        Log::info("To: " . $formattedTo);
        Log::info("Message: " . $message);
        Log::info("---------------------------------");

        // Example with Twilio:
        // $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        // $twilio->messages->create('whatsapp:' . $formattedTo, [
        //     'from' => 'whatsapp:' . env('TWILIO_WHATSAPP_FROM'),
        //     'body' => $message
        // ]);
    }

    /**
     * Sends a notification for a pending visit registration.
     *
     * @param Kunjungan $kunjungan
     */
    public function sendPending(Kunjungan $kunjungan, string $qrCodeUrl)
    {
        $message = "Pendaftaran Anda berhasil! Simpan QR Code Anda.\n\n"
                 . "Kode Pendaftaran: *{$kunjungan->kode_kunjungan}*\n"
                 . "Status: MENUNGGU KEDATANGAN\n\n"
                 . "Tunjukkan QR Code dari link di bawah ini kepada petugas saat tiba di Lapas untuk persetujuan final.\n"
                 . $qrCodeUrl . "\n\n"
                 . "Terima kasih.";

        $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }

    /**
     * Sends a notification for an approved visit, including a link to the QR code.
     *
     * @param Kunjungan $kunjungan
     * @param string $qrCodeUrl The publicly accessible URL to the generated QR code image.
     */
    public function sendApproved(Kunjungan $kunjungan, string $qrCodeUrl)
    {
        $message = "Pendaftaran kunjungan Anda telah DISETUJUI.\n\n"
                 . "Kode Pendaftaran: *{$kunjungan->kode_kunjungan}*\n"
                 . "Nama WBP: {$kunjungan->wbp->nama}\n"
                 . "Tanggal: " . Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') . "\n\n"
                 . "Silakan tunjukkan QR Code pada link di bawah ini kepada petugas saat melakukan kunjungan:\n"
                 . $qrCodeUrl . "\n\n"
                 . "Terima kasih.";

        $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }

    /**
     * Sends a notification for a rejected visit.
     *
     * @param Kunjungan $kunjungan
     */
    public function sendRejected(Kunjungan $kunjungan)
    {
        $message = "Mohon maaf, pendaftaran kunjungan Anda dengan kode *{$kunjungan->kode_kunjungan}* telah DITOLAK.\n\n"
                 . "Silakan cek alasan penolakan dan lakukan pendaftaran ulang di website kami.\n"
                 . "Lihat detail pendaftaran Anda di sini: " . route('kunjungan.status', $kunjungan->id);

        $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }

    /**
     * Sends a reminder notification for an upcoming visit.
     *
     * @param Kunjungan $kunjungan
     */
    public function sendReminder(Kunjungan $kunjungan)
    {
        // Ensure WBP relationship is loaded for message content
        $kunjungan->load('wbp');

        $message = "Halo {$kunjungan->nama_pengunjung},\n\n"
                 . "Ini adalah pengingat bahwa jadwal kunjungan tatap muka Anda adalah *BESOK*.\n"
                 . "Detail Kunjungan:\n"
                 . "Tanggal: " . \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') . "\n"
                 . "Sesi: " . ucfirst($kunjungan->sesi) . "\n"
                 . "Warga Binaan: " . $kunjungan->wbp->nama . "\n\n"
                 . "Mohon siapkan diri Anda dan pastikan membawa identitas asli serta QR Code Anda.\n"
                 . "Link QR Code: " . route('kunjungan.verify', $kunjungan->qr_token) . "\n\n"
                 . "Terima kasih atas perhatiannya.";
        
        $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }

    /**
     * Sends a notification for a completed visit.
     *
     * @param Kunjungan $kunjungan
     */
    public function sendCompleted(Kunjungan $kunjungan)
    {
        $message = "Terima kasih atas kunjungan Anda di Lapas Jombang!\n\n"
                 . "Kunjungan Anda pada tanggal " . \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') . " untuk WBP {$kunjungan->wbp->nama} telah selesai.\n\n"
                 . "Kami sangat menghargai waktu Anda. Mohon kesediaannya untuk mengisi survei kepuasan layanan kami melalui link berikut:\n"
                 . route('survey.create') . "\n\n"
                 . "Masukan Anda sangat berarti bagi kami untuk menjadi lebih baik.";

        $this->sendMessage($kunjungan->no_wa_pengunjung, $message);
    }
}
