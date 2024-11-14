<?php

namespace App\Http\Controllers;

use App\Services\PayU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $schedule = array_values(array_filter($request->all(), fn($key) => str_starts_with($key, 'course_schedule'), ARRAY_FILTER_USE_KEY));
        Session::put('schedule', $schedule);
        $payu_obj = new PayU();
        $payu_obj->env_prod = config('services.payu.environment');
        $payu_obj->key = config('services.payu.key');
        $payu_obj->salt = config('services.payu.salt');
        $payu_obj->initGateway();
        $params = [
            "surl" => route('payment.response'),
            "furl" => route('payment.response'),
            "txnid" => uniqid(),
            "amount" => $request->amount,
            "productinfo" => $request->name,
            "firstname" => Auth::user()->name,
            "lastname" => '',
            "zipcode" => '',
            "email" => Auth::user()->email,
            "phone" => Auth::user()->phone,
            "address1" => '',
            "city" => '',
            "state" => '',
            "country" => ''
        ];
        $payu_obj->showPaymentForm($params);
    }

    public function response(Request $request)
    {
        dd(Session::get('schedule'));
    }
}
