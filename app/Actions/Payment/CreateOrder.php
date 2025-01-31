<?php

namespace App\Actions\Payment;

use App\Actions\DecodePrice;
use App\Models\Order;
use App\Models\OrderNumber;
use Illuminate\Support\Facades\Session;

class CreateOrder
{
    public function execute($userID, $usd)
    {
        $orderNumberPrefix = OrderNumber::first()->prefix;
        $paymentMethod = Session::get('paymentMethod');
        $productName = Session::get('productName');
        $productType = Session::get('productType');
        $payablePrice = Session::get('payablePrice');
        $discount = Session::get('discount');
        $model = (new ModelFromProductType)->execute($productType);
        $item = $model::where('slug', $productName)->firstOrFail();
        switch ($paymentMethod) {
            case 'payu':
                $payablePrice = $payablePrice;
                $prices = (new DecodePrice)->execute($payablePrice, $discount);
                break;
            case 'paypal':
                $payablePrice = $usd;
                $prices = (new DecodePrice)->execute($payablePrice, $discount);
                break;
            case 'stripe':
                $payablePrice = $usd;
                $prices = (new DecodePrice)->execute($payablePrice, $discount);
                break;
            case 'phonepe':
                $payablePrice = $payablePrice;
                $prices = (new DecodePrice)->execute($payablePrice, $discount);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }

        return Order::create([
            'user_id' => $userID,
            'course_id' => $item->courses ? null : $item->id,
            'package_id' => $item->courses ? $item->id : null,
            'order_number' => $orderNumberPrefix . $userID . now()->format('YmdHis'),
            'courseOrPackage_price' => $prices['actualPrice'],
            'sgst' => $prices['sgst'],
            'cgst' => $prices['cgst'],
            'discount' => $prices['discount']
        ]);
    }
}
