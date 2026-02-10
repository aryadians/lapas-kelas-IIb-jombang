<?php

namespace App\Mail;

use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
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
            case KunjunganStatus::APPROVED:
                $subject = '✅ Tiket Kunjungan Disetujui - Lapas Kelas IIB Jombang';
                $headline = 'Kunjungan Disetujui';
                $message = 'Selamat! Pendaftaran kunjungan Anda telah disetujui. Silakan tunjukkan QR Code terlampir kepada petugas saat kedatangan.';
                $color = '#10B981'; // Hijau
                break;

            case KunjunganStatus::REJECTED:
                $subject = '❌ Pendaftaran Kunjungan Ditolak - Lapas Kelas IIB Jombang';
                $headline = 'Mohon Maaf';
                $message = 'Pendaftaran kunjungan Anda tidak dapat kami setujui saat ini. Hal ini mungkin dikarenakan kuota penuh atau data tidak sesuai.';
                $color = '#EF4444'; // Merah
                break;

            default: // pending
                $subject = '✅ Pendaftaran Berhasil - Lapas Kelas IIB Jombang';
                $headline = 'PENDAFTARAN BERHASIL';
                $message = 'Selamat! Pendaftaran kunjungan Anda telah berhasil kami terima. Silahkan tunjukkan QR Code terlampir kepada petugas kami saat kedatangan di Lapas Kelas IIB Jombang.';
                $color = '#3B82F6'; // Biru (lebih cocok untuk 'berhasil' daripada kuning)
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
