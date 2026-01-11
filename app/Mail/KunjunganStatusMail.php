<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class KunjunganStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $kunjungan;
    public $qrCodePath;

    /**
     * Create a new message instance.
     *
     * @param Kunjungan $kunjungan Data kunjungan
     * @param string|null $qrCodePath Path fisik file QR Code (jika ada)
     */
    public function __construct(Kunjungan $kunjungan, $qrCodePath = null)
    {
        $this->kunjungan = $kunjungan;
        $this->qrCodePath = $qrCodePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = '';
        $headline = '';
        $message = '';
        $color = '';

        // 1. Tentukan Konten Berdasarkan Status
        switch ($this->kunjungan->status) {
            case 'approved':
                $subject = '✅ Tiket Kunjungan Disetujui - Lapas Kelas IIB Jombang';
                $headline = 'Kunjungan Disetujui';
                $message = 'Selamat! Pendaftaran kunjungan Anda telah disetujui. Silakan tunjukkan QR Code terlampir kepada petugas saat kedatangan.';
                $color = '#10B981'; // Hijau
                break;

            case 'rejected':
                $subject = '❌ Pendaftaran Kunjungan Ditolak - Lapas Kelas IIB Jombang';
                $headline = 'Mohon Maaf';
                $message = 'Pendaftaran kunjungan Anda tidak dapat kami setujui saat ini. Hal ini mungkin dikarenakan kuota penuh atau data tidak sesuai.';
                $color = '#EF4444'; // Merah
                break;

            default: // pending
                $subject = '⏳ Menunggu Verifikasi - Lapas Kelas IIB Jombang';
                $headline = 'Pendaftaran Berhasil';
                $message = 'Data pendaftaran Anda telah kami terima. Mohon tunggu verifikasi dari admin. Anda akan menerima email notifikasi selanjutnya setelah status disetujui.';
                $color = '#F59E0B'; // Kuning/Orange
                break;
        }

        // 2. Setup View Email
        $email = $this->subject($subject)
            ->view('emails.kunjungan-status') // Pastikan file blade ini ada
            ->with([
                'headline' => $headline,
                'content' => $message,
                'color' => $color,
                'kunjungan' => $this->kunjungan
            ]);

        // 3. Lampirkan QR Code (Jika Ada & Valid)
        if ($this->qrCodePath && file_exists($this->qrCodePath)) {

            // Ambil ekstensi file (.png atau .svg)
            $extension = strtolower(pathinfo($this->qrCodePath, PATHINFO_EXTENSION));

            // Tentukan MIME type yang tepat agar email client bisa merender
            $mime = match ($extension) {
                'svg' => 'image/svg+xml',
                'png' => 'image/png',
                default => 'application/octet-stream',
            };

            $email->attach($this->qrCodePath, [
                'as' => 'qrcode-kunjungan.' . $extension,
                'mime' => $mime,
            ]);
        }

        return $email;
    }
}
