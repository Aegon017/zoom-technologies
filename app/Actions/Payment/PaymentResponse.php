<?php

namespace App\Actions\Payment;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentResponse
{
    public function execute(Request $request, Order $order, $couponId)
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
            'coupon_id' => $couponId,
        ];
        $updateOrderPayment->execute($order->id, $data);
        if ($status == 'success') {
            $address = Address::where('user_id', Auth::id())->first();
            $order->invoice = $generateInvoice->execute($order, $address);
            $order->save();
            if ($couponId) {
                $redeemer = $order->user;
                $redeemer->redeemCoupon(Coupon::find($couponId)?->code);
            }
        }
        $sendEmails->execute($order);
    }
}
