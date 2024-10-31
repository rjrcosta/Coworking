<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class MailContacto extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $email;
    public $mensagem;
    /**
     * Create a new message instance.
     */
    public function __construct($nome, $email, $mensagem)
    {
       
        $this -> nome = $nome;
        $this -> email = $email;
        $this -> mensagem = $mensagem;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail Contacto',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
        return new Content(
            view: 'emailcontacto',
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
