<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KunjunganPending extends Mailable
{
    use Queueable, SerializesModels;

    public $kunjungan;
    public $qrCodePath; // Tambahkan properti ini

    // Terima data kunjungan DAN path QR Code
    public function __construct($kunjungan, $qrCodePath = null)
    {
        $this->kunjungan = $kunjungan;
        $this->qrCodePath = $qrCodePath;
    }

    public function build()
    {
        $email = $this->subject('PENDAFTARAN BERHASIL - MENUNGGU VERIFIKASI')
            ->view('emails.kunjungan_pending'); // Pastikan view ini ada

        // Jika ada path QR Code, lampirkan file
        if ($this->qrCodePath) {
            $email->attach($this->qrCodePath, [
                'as' => 'qrcode-kunjungan.svg',
                'mime' => 'image/svg+xml',
            ]);
        }

        return $email;
    }
}
