<?php

namespace App\Actions\Payment;

use App\Actions\CalculatePrice;
use App\Actions\DecodePrice;
use App\Models\Order;
use App\Models\Tax;
use Illuminate\Http\Request;

class CreateOrder
{
    public function execute(Request $request, $userId, $usd)
    {
        $payablePrice = $request->payable_price;
        $productType = $request->product_type;
        $model = (new ModelFromProductType())->execute($productType);
        $item = $model::where('slug', $request->name)->firstOrFail();
        switch ($request->payment_method) {
            case 'payu':
                $payablePrice = $payablePrice;
                $prices = (new DecodePrice())->execute($payablePrice);
                break;
            case 'paypal':
                $payablePrice = $usd;
                $prices = (new DecodePrice())->execute($payablePrice);
                break;
            case 'stripe':
                $payablePrice = $usd;
                $prices = (new DecodePrice())->execute($payablePrice);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
        return Order::create([
            'user_id' => $userId,
            'order_number' => 'zt_' . $userId . now()->format('YmdHis'),
            'payment_method' => $request->payment_method,
            'amount' => $payablePrice,
            'course_name' => $item->name,
            'course_thumbnail' => $item->thumbnail,
            'course_thumbnail_alt' => $item->thumbnail_alt,
            'course_duration' => $item->duration,
            'course_duration_type' => $item->duration_type,
            'course_price' => $prices['actualPrice'],
            'sgst' => $prices['sgstPercentage'],
            'cgst' => $prices['cgstPercentage'],
        ]);
    }
}
