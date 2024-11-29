<?php

namespace App\Listeners;

use App\Actions\Payment\AttachScheduleToOrder;
use App\Actions\Payment\GenerateInvoice;
use App\Actions\Payment\SendEmails;
use App\Actions\Payment\UpdateOrderPayment;
use App\Events\ManualOrderCreatedEvent;
use App\Mail\UserEnrollMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CreateOrderSendMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ManualOrderCreatedEvent $event): void
    {
        $userName = $event->manualOrder->user_name;
        $userEmail = $event->manualOrder->user_email;
        $userPhone = $event->manualOrder->user_phone;
        $password = uniqid(8);
        $user = new User;
        $user->name = $userName;
        $user->email = $userEmail;
        $user->phone = $userPhone;
        $user->password = $password;
        $user->save();
        Mail::to($userEmail)->send(new UserEnrollMail($user, $password));
        $userId = $user->id;
        $order = new Order;
        $order->user_id = $userId;
        $order->course_id = $event->manualOrder->package_id ? null : $event->manualOrder->course_id;
        $order->package_id = $event->manualOrder->package_id;
        $order->order_number = 'zt_'.$userId.now()->format('YmdHis');
        $order->courseOrPackage_price = $event->manualOrder->course_price;
        $order->cgst = $event->manualOrder->cgst;
        $order->sgst = $event->manualOrder->sgst;
        $order->save();
        if ($event->manualOrder->package_id) {
            $scheduleIDs = $event->manualOrder->packageSchedule_id;
            $attachScheduleToOrder = new AttachScheduleToOrder;
            $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        } else {
            $scheduleIDs[] = $event->manualOrder->schedule_id;
            $attachScheduleToOrder = new AttachScheduleToOrder;
            $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        }
        $data = [
            'paymentId' => 'N/A',
            'method' => 'Counsellor',
            'mode' => $event->manualOrder->payment_mode,
            'description' => 'created by counsellor',
            'date' => today(),
            'time' => now(),
            'status' => 'success',
            'amount' => $event->manualOrder->amount,
            'currency' => 'Rs',
        ];
        $updateOrderPayment = new UpdateOrderPayment;
        $updateOrderPayment->execute($order->id, $data);
        $generateInvoice = new GenerateInvoice;
        $order->invoice = $generateInvoice->execute($order);
        $order->save();
        $sendEmails = new SendEmails;
        $sendEmails->execute($order);
    }
}
