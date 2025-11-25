<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactBericht extends Mailable
{
    use Queueable, SerializesModels;

    public $gegevens;

    public function __construct(array $gegevens)
    {
        $this->gegevens = $gegevens;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuw contactbericht',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
