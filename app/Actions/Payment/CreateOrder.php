<?php

namespace App\Actions\Payment;

use App\Models\Order;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateOrder
{
    public function execute($request,$modelFromProductType, $productType)
    {
        $SGST = Tax::where('name', 'SGST')->first()->rate;
        $CGST = Tax::where('name', 'SGST')->first()->rate;
        $totalPrice = $request->amount;
        $coursePrice = $totalPrice / (1 + ($SGST + $CGST) / 100);
        $sgst = $coursePrice * ($SGST / 100);
        $cgst = $coursePrice * ($CGST / 100);
        $model = $modelFromProductType->execute($productType);
        $item = $model::where('slug', $request->productinfo)->firstOrFail();
        return Order::firstOrNew(['transaction_id' => $request->txnid], [
            'user_id' => Auth::id(),
            'order_number' => 'zt_' . Auth::id() . now()->format('YmdHis'),
            'payu_id' => $request->mihpayid,
            'payment_mode' => $request->mode,
            'payment_time' => $request->addedon,
            'payment_desc' => $request->field9,
            'amount' => $totalPrice,
            'status' => $request->status,
            'course_name' => $item->name,
            'course_thumbnail' => $item->thumbnail,
            'course_thumbnail_alt' => $item->thumbnail_alt,
            'course_duration' => $item->duration,
            'course_duration_type' => $item->duration_type,
            'course_price' => $coursePrice,
            'sgst' => $sgst,
            'cgst' => $cgst,
        ]);
    }
}
