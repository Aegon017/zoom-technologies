<?php

namespace App\Actions\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentResponse
{
    public function execute(Request $request, Order $order)
    {
        $generateInvoice = new GenerateInvoice();
        $sendEmails = new SendEmails();
        $updateOrderPayment = new UpdateOrderPayment();
        $updateOrderPayment->execute($request, $order);
        if ($request->status == 'success') {
            $order->invoice = $generateInvoice->execute($order->id);
            $order->save();
        }
        $sendEmails->execute($order);
    }
}
