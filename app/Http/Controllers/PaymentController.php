<?php

namespace App\Http\Controllers;

use App\Actions\Payment\AttachScheduleToOrder;
use App\Actions\Payment\CreateOrder;
use App\Actions\Payment\PaymentResponse;
use App\Models\Order;
use App\Models\Tax;
use App\Models\Usd;
use App\Services\PayPalPayment;
use App\Services\PayU;
use App\Services\PayUPayment;
use App\Services\StripePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function initiate(Request $request, PayUPayment $payUPayment, PayPalPayment $payPalPayment, StripePayment $stripePayment, CreateOrder $createOrder, AttachScheduleToOrder $attachScheduleToOrder)
    {
        $user = Auth::user();
        $usd_rate = Usd::find(1)->first()->value;
        $usd = round(($request->payable_price / $usd_rate) * 100, 0);
        $order = $createOrder->execute($request, $user->id, $usd);
        dd($order);
        Session::put('order_id', $order->id);
        $scheduleIDs = array_values(array_filter($request->all(), fn($key) => str_starts_with($key, 'course_schedule'), ARRAY_FILTER_USE_KEY));
        $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        switch ($request->payment_method) {
            case 'payu':
                $payUPayment->execute($request, $user);
                break;
            case 'paypal':
                $payPalPayment->execute($request, $user, $usd);
                break;
            case 'stripe':
                $stripePayment->execute($request, $user, $usd);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
    }

    public function success(Request $request, PaymentResponse $paymentResponse)
    {
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        $paymentResponse->execute($request, $order);
        return view('pages.payment-success', compact('order'));
    }

    public function failure(Request $request, PaymentResponse $paymentResponse)
    {
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        $paymentResponse->execute($request, $order);
        return view('pages.payment-failure', compact('order'));
    }
}
