<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduleDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $schedule;

    public $user;

    public $stickyContact;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $schedule, $user, $stickyContact)
    {
        $this->subject = $subject;
        $this->schedule = $schedule;
        $this->user = $user;
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
            view: 'pages.schedule-deleted',
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
