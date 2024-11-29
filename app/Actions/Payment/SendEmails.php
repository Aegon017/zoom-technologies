<?php

namespace App\Actions\Payment;

use App\Mail\AdminMail;
use App\Mail\MeetingMail;
use App\Mail\OrderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class SendEmails
{
    public function execute(Order $order)
    {
        $to = $order->user->email;
        $orderMailSubject = "Payment {$order->payment->status} on your order with Zoom Technologies";
        Mail::to($to)->send(new OrderMail($orderMailSubject, $order));

        if ($order->payment->status === 'success') {
            $adminEmail = 'kondanagamalleswararao016@gmail.com';
            $adminMailSubject = 'New Enrollment';
            Mail::to($adminEmail)->send(new AdminMail($adminMailSubject, $order));
            $meetingMailSubject = 'Zoom Technologies Training Session Details';
            Mail::to($to)->send(new MeetingMail($meetingMailSubject, $order));
        }
    }
}
