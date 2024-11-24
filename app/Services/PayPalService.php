<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    public function createOrder(array $orderData)
    {
        try {
            $order = $this->provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $orderData['currency'] ?? 'USD',
                            'value' => $orderData['total']
                        ],
                        'description' => $orderData['description'] ?? 'Order Description'
                    ]
                ]
            ]);

            return $order;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function capturePayment($orderId)
    {
        try {
            $result = $this->provider->capturePaymentOrder($orderId);
            return $result;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function verifyTransaction($orderId)
    {
        try {
            $order = $this->provider->showOrderDetails($orderId);
            return $order;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
