<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $agent;

    public function __construct($data, $agent)
    {
        $this->data = $data;
        $this->agent = $agent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau message depuis votre mini-site',
            replyTo: [
                new Address($this->data['email'], $this->data['nom']),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}