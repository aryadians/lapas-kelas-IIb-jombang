<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WhatsAppProviderFailure extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $subject = sprintf('[ALERT] WhatsApp provider failures (target: %s)', $this->details['target'] ?? 'unknown');

        return $this->subject($subject)
            ->view('emails.wa_provider_failure')
            ->with($this->details);
    }
}
