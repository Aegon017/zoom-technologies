<?php

namespace App\Services;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class PayPalPayment
{
    public function execute($user, $txnId, $usd, $productInfo)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $request->name,
                        ],
                        'unit_amount' => $usd,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.failure'),
        ]);
        return redirect($session->url);
    }
}
