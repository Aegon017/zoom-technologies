<?php

namespace App\Actions\Payment;

use App\Actions\DecodePrice;
use App\Models\Order;
use Illuminate\Http\Request;

class CreateOrder
{
    public function execute(Request $request, $userId, $usd)
    {
        $payablePrice = $request->payable_price;
        $productType = $request->product_type;
        $model = (new ModelFromProductType)->execute($productType);
        $item = $model::where('slug', $request->name)->firstOrFail();
        switch ($request->payment_method) {
            case 'payu':
                $payablePrice = $payablePrice;
                $prices = (new DecodePrice)->execute($payablePrice);
                break;
            case 'paypal':
                $payablePrice = $usd;
                $prices = (new DecodePrice)->execute($payablePrice);
                break;
            case 'stripe':
                $payablePrice = $usd;
                $prices = (new DecodePrice)->execute($payablePrice);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }

        return Order::create([
            'user_id' => $userId,
            'course_id' => $item->courses ? null : $item->id,
            'package_id' => $item->courses ? $item->id : null,
            'order_number' => 'zt_'.$userId.now()->format('YmdHis'),
            'courseOrPackage_price' => $prices['actualPrice'],
            'sgst' => $prices['sgst'],
            'cgst' => $prices['cgst'],
        ]);
    }
}
