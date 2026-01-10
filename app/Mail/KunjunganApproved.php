<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KunjunganApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $kunjungan;
    public $qrCode;

    /**
     * Create a new message instance.
     *
     * @param Kunjungan $kunjungan
     * @param mixed $qrCode Raw QR code image data.
     */
    public function __construct(Kunjungan $kunjungan, $qrCode)
    {
        $this->kunjungan = $kunjungan;
        $this->qrCode = $qrCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('✅ Kunjungan DISETUJUI - Tiket Masuk Lapas')
            ->view('emails.kunjungan_approved')
            ->attachData($this->qrCode, 'qrcode.png', [
                'mime' => 'image/png',
            ]);
    }
}
