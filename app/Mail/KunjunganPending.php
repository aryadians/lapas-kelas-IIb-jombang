<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KunjunganPending extends Mailable
{
    use Queueable, SerializesModels;

    public $kunjungan;

    public function __construct(Kunjungan $kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }

    public function build()
    {
        return $this->subject('⏳ Pendaftaran Berhasil - Menunggu Verifikasi')
            ->view('emails.kunjungan_pending');
    }
}
