<?php

namespace App\Actions\Payment;

use App\Mail\AdminMail;
use App\Mail\MeetingMail;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\StickyContact;
use App\Models\Thankyou;
use Illuminate\Support\Facades\Mail;

class SendEmails
{
    public function execute(Order $order)
    {
        $stickyContact = StickyContact::with(['mobileNumber', 'email'])->first();
        $to = $order->user->email;
        $orderMailSubject = "Payment {$order->payment->status} on your order with Zoom Technologies";
        $thankyou = Thankyou::first();
        Mail::to($to)->send(new OrderMail($orderMailSubject, $order, $thankyou, $stickyContact));

        if ($order->payment->status === 'success') {
            $adminEmail = Env('ADMIN_EMAIL');
            $adminMailSubject = 'New Enrollment';
            Mail::to($adminEmail)->send(new AdminMail($adminMailSubject, $order, $stickyContact));
            $meetingMailSubject = 'Zoom Technologies Training Session Details';
            Mail::to($to)->send(new MeetingMail($meetingMailSubject, $order, $stickyContact));
        }
    }
}
