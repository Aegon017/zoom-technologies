<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $subject;

    public $stickyContact;


    /**
     * Create a new message instance.
     */
    public function __construct($meetingMailSubject, $order, $stickyContact)
    {
        $this->subject = $meetingMailSubject;
        $this->order = $order;
        $this->stickyContact = $stickyContact;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'pages.meeting-mail',
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
