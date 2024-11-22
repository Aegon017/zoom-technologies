<?php

namespace App\Services;

class PayUPayment
{
    public function __construct() {}

    public function execute($user, $txnId, $payablePrice, $productInfo)
    {
        $payu_obj = new PayU();
        $payu_obj->env_prod = config('services.payu.environment');
        $payu_obj->key = config('services.payu.key');
        $payu_obj->salt = config('services.payu.salt');
        $payu_obj->initGateway();
        $params = [
            "surl" => route('payment.success'),
            "furl" => route('payment.failure'),
            "txnid" => $txnId,
            "amount" => $payablePrice,
            "productinfo" => $productInfo,
            "firstname" => $user->name,
            "lastname" => '',
            "zipcode" => '',
            "email" => $user->email,
            "phone" => $user->phone,
            "address1" => '',
            "city" => '',
            "state" => '',
            "country" => ''
        ];
        $payu_obj->showPaymentForm($params);
    }
}
