<?php

namespace App\Actions\Payment;

use App\Actions\CalculatePrice;
use App\Models\Order;
use App\Models\Tax;
use Illuminate\Http\Request;

class CreateOrder
{
    public function execute(Request $request, $userId, $usd)
    {
        $coursePrice = $request->course_price;
        $productType = $request->product_type;
        (new CalculatePrice())->execute($coursePrice);
        $model = (new ModelFromProductType())->execute($productType);
        $item = $model::where('slug', $request->name)->firstOrFail();
        $amount = $request->amount;
        switch ($request->payment_method) {
            case 'payu':
                $payable_amount = $amount;
                break;
            case 'paypal':
                $payable_amount = $usd;
                break;
            case 'stripe':
                $payable_amount = $usd;
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
        return Order::create([
            'user_id' => $userId,
            'order_number' => 'zt_' . $userId . now()->format('YmdHis'),
            'payment_method' => $request->payment_method,
            'amount' => $payable_amount,
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
