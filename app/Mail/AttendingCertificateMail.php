<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttendingCertificateMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $pdfFileName;
    public $userName;
    public $courseName;
    /**
     * Create a new message instance.
     */
    public function __construct($pdfFileName, $subject, $userName, $courseName)
    {
        $this->subject = $subject;
        $this->pdfFileName = $pdfFileName;
        $this->userName = $userName;
        $this->courseName = $courseName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope();
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'pages.attendance-certificate-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(asset($this->pdfFileName))
        ];
    }
}
