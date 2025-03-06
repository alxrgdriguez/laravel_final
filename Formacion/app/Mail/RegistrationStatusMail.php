<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $statusMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
        $this->statusMessage = $registration->statusReg->value === 'accepted'
            ? 'Tu inscripción ha sido aceptada'
            : 'Tu inscripción ha sido rechazada';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Estado de tu inscripción en ' . $this->registration->course->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration_status',
            with: [
                'registration' => $this->registration, // Pasar la variable a la vista
                'statusMessage' => $this->statusMessage, // Pasar el mensaje de estado
            ],
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
