<?php

namespace App\Actions\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

class UpdateOrderPayment
{
    public function execute(Request $request, Order $order)
    {
        $order->payment_id = $request->mihpayid;
        $order->payment_time = $request->addedon;
        $order->payment_desc = $request->field9;
        $order->amount = $request->amount;
        $order->status = $request->status;
    }
}
