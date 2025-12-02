<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SchoolAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $accounts;

    /**
     * Create a new message instance.
     */
    public function __construct($school, $accounts)
    {
        $this->school = $school;
        $this->accounts = $accounts;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Uw school is geaccepteerd')
                    ->view('emails.school_accepted');
    }
}
