<?php

namespace App\Services;

use Illuminate\Http\Request;

class PayUPayment
{
    public function __construct() {}

    public function execute(Request $request, $user)
    {
        $payu_obj = new PayU();
        $payu_obj->env_prod = config('services.payu.environment');
        $payu_obj->key = config('services.payu.key');
        $payu_obj->salt = config('services.payu.salt');
        $payu_obj->initGateway();
        $params = [
            "surl" => route('payment.success'),
            "furl" => route('payment.failure'),
            "txnid" => uniqid(),
            "amount" => $request->amount,
            "productinfo" => $request->name,
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
