<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyLinkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $kunjungan;
    public $surveyUrl;

    /**
     * Create a new message instance.
     *
     * @param Kunjungan $kunjungan Data kunjungan
     * @param string $surveyUrl URL Survei
     */
    public function __construct(Kunjungan $kunjungan, string $surveyUrl)
    {
        $this->kunjungan = $kunjungan;
        $this->surveyUrl = $surveyUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->to($this->kunjungan->email_pengunjung, $this->kunjungan->nama_pengunjung)
            ->subject('Survei Kepuasan Layanan Kunjungan - Lapas Jombang')
            ->view('emails.survey-link')
            ->with([
                'kunjungan' => $this->kunjungan,
                'surveyUrl' => $this->surveyUrl
            ]);
    }
}
