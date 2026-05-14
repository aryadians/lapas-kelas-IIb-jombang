<?php

namespace App\Mail;

use App\Models\Kunjungan;
use App\Models\Wbp;
use App\Models\WbpRestriction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RestrictionBroadcastMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $kunjungan;
    public $wbp;
    public $restriction;

    /**
     * Create a new message instance.
     */
    public function __construct(Kunjungan $kunjungan, Wbp $wbp, WbpRestriction $restriction)
    {
        $this->kunjungan = $kunjungan;
        $this->wbp = $wbp;
        $this->restriction = $restriction;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penting: Pembatalan Kunjungan Lapas Jombang',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.restriction_broadcast',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
