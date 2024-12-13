<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $order;

    public $thankyou;

    public function __construct($orderMailSubject, $order, $thankyou)
    {
        $this->subject = $orderMailSubject;
        $this->order = $order;
        $this->thankyou = $thankyou;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'pages.order-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $order = $this->order;
        if ($order->payment->status == 'success') {

            return [
                Attachment::fromPath(asset($order->invoice)),
            ];
        } else {
            return [];
        }
    }
}
