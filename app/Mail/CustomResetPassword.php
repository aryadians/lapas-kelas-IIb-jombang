<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\VisitSetting;

class CustomResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $settings;

    /**
     * Create a new message instance.
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->settings = VisitSetting::pluck('value', 'key');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password - Lapas Kelas IIB Jombang',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.password-reset',
            with: [
                'url' => $this->url,
                'appName' => 'Lapas Kelas IIB Jombang',
            ],
        );
    }
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
