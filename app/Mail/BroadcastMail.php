<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $body;

    public function __construct($subject, $body)
    {
        $this->subjectLine = $subject;
        $this->body = $body;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.broadcast');
    }
}
