<?php

namespace App\Actions\Payment;

use App\Models\Order;
use App\Models\Payment;

class UpdateOrderPayment
{
    public function execute($order_id, $data)
    {
        $payment = new Payment;
        $payment->order_id = $order_id;
        if ($data['status'] == 'success') {
            $payment->reference_number = $this->setReferenceNumber();
        } else {
            $payment->reference_number = null;
        }
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

    private function setReferenceNumber()
    {
        $lastReferenceNo = Payment::where('status', 'success')
            ->latest('created_at')
            ->value('reference_number');
        $referenceNumber = $lastReferenceNo ? (intval(substr($lastReferenceNo, 3)) + 1) : 1;
        $reference_no = 'REF' . str_pad($referenceNumber, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }
}
