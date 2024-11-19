<?php

namespace App\Http\Controllers;

use App\Actions\Payment\AttachScheduleToOrder;
use App\Actions\Payment\CreateOrder;
use App\Actions\Payment\GenerateInvoice;
use App\Actions\Payment\ModelFromProductType;
use App\Actions\Payment\SendEmails;
use App\Models\Tax;
use App\Services\PayU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PaypalServerSdkLib\Authentication\ClientCredentialsAuthCredentialsBuilder;
use PaypalServerSdkLib\Controllers\OrdersController;
use PaypalServerSdkLib\Environment;
use PaypalServerSdkLib\Logging\LoggingConfigurationBuilder;
use PaypalServerSdkLib\Logging\RequestLoggingConfigurationBuilder;
use PaypalServerSdkLib\Logging\ResponseLoggingConfigurationBuilder;
use PaypalServerSdkLib\Models\OAuthToken;
use PaypalServerSdkLib\Models\Payer;
use PaypalServerSdkLib\PaypalServerSdkClient;
use PaypalServerSdkLib\PaypalServerSdkClientBuilder;
use Psr\Log\LogLevel;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $scheduleIDs = array_values(array_filter($request->all(), fn($key) => str_starts_with($key, 'course_schedule'), ARRAY_FILTER_USE_KEY));
        Session::put('scheduleIDs', $scheduleIDs);
        Session::put('productType', $request->product_type);
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

    public function response(Request $request, CreateOrder $createOrder, SendEmails $sendEmails, ModelFromProductType $modelFromProductType, AttachScheduleToOrder $attachScheduleToOrder, GenerateInvoice $generateInvoice)
    {
        $scheduleIDs = Session::get('scheduleIDs');
        $productType = Session::get('productType');
        $order = $createOrder->execute($request, $modelFromProductType, $productType);
        $order->save();
        $attachScheduleToOrder->execute($scheduleIDs, $order);
        if ($order->status == 'success') {
            $order->invoice = $generateInvoice->execute($order);
            $order->save();
        }
        $sendEmails->execute($order);
        return view("pages.payment-$order->status", compact('order'));
    }
}
