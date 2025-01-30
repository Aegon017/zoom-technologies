<?php

namespace App\Actions\Payment;

use App\Models\Payment;

class UpdateOrderPayment
{
    public function execute($order_id, $data)
    {
        $payment = new Payment;
        $payment->order_id = $order_id;
        if ($data['status'] == 'success') {
            $payment->receipt_number = $this->setReceiptNumber();
        } else {
            $payment->receipt_number = null;
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

    private function setReceiptNumber()
    {
        $lastReceiptNo = Payment::where('status', 'success')
            ->latest('created_at')
            ->value('receipt_number');
        $receiptNumber = $lastReceiptNo ? (intval(substr($lastReceiptNo, 3)) + 1) : 1;
        $receipt_no = 'ZTR'.str_pad($receiptNumber, 6, '0', STR_PAD_LEFT);

        return $receipt_no;
    }
}
