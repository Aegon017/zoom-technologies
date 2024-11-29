<?php

namespace App\Actions\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentResponse
{
    public function execute(Request $request, Order $order)
    {
        $generateInvoice = new GenerateInvoice;
        $sendEmails = new SendEmails;
        $updateOrderPayment = new UpdateOrderPayment;
        $paymentId = $request->mihpayid;
        $method = 'payu';
        $mode = $request->mode;
        $description = $request->field9;
        $date = $request->addedon;
        $time = $request->addedon;
        $status = $request->status;
        $amount = $request->amount;
        $data = [
            'paymentId' => $paymentId,
            'method' => $method,
            'mode' => $mode,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'status' => $status,
            'amount' => $amount,
            'currency' => 'Rs',
        ];
        $updateOrderPayment->execute($order->id, $data);
        if ($request->status == 'success') {
            $order->invoice = $generateInvoice->execute($order);
            $order->save();
        }
        $sendEmails->execute($order);
    }
}
