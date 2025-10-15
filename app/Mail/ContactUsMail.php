<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan Baru dari Formulir Kontak eyetails.co',
        );
    }

    public function content(): Content
    {
        // Akan merender view resources/views/emails/contact.blade.php
        return new Content(
            markdown: 'emails.contact',
        );
    }
}
