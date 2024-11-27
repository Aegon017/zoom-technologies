<?php

namespace App\Actions\Payment;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class UpdateOrderPayment
{
public function execute($order_id, $data)
    {
        $payment = new Payment();
        $payment->order_id = $order_id;
        $payment->payment_id = $data['paymentId'];
        $payment->method = $data['method'];
        $payment->mode = $data['mode'];
        $payment->description = $data['description'];
        $payment->date = $data['date'];
        $payment->time = $data['time'];
        $payment->status = $data['status'];
        $payment->amount = $data['amount'];
        $payment->currency = $data['currency'];
        $payment->save();
    }
}
