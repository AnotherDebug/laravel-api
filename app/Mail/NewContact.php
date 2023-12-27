<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContact extends Mailable
{
    use Queueable, SerializesModels;

    //variabile d'istanza pubblica
    public $lead;

    /**
     * Create a new message instance.
     */

     //quando viene creato un nuovo contatto lo passiamo come parametro del costruttore
    public function __construct($_lead)
    {
        //nuova istanza salvata nella variabile
        $this->lead = $_lead;
    }

    /**
     * Get the message envelope.
     */

     //metodo envelope che definisce i dettagli di oggetto del messaggio ed inderizzo di risposta
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact',
            replyTo: $this->lead->email
        );
    }

    /**
     * Get the message content definition.
     */

     //la mail che arriva viene confezionata in content, di conseguenza restituisco la view a content (contenuto della mail letta dal mailer)
    public function content(): Content
    {
        return new Content(
            view: 'mail.new_contact',
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
