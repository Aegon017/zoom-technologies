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
use Srmklive\PayPal\Services\PayPal;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function initiate(Request $request, PayUPayment $payUPayment, CreateOrder $createOrder, AttachScheduleToOrder $attachScheduleToOrder)
    {

        $user = Auth::user();
        $usd_rate = Usd::first()->value ?? 0;
        $txnId = uniqid();
        $payablePrice = $request->payable_price;
        $productInfo = $request->name;
        $usd = round(($payablePrice / $usd_rate) * 100, 0);
        $order = $createOrder->execute($request, $user->id, $usd);
        Session::put('order_id', $order->id);
        $scheduleIDs = array_values(array_filter($request->all(), fn($key) => str_starts_with($key, 'course_schedule'), ARRAY_FILTER_USE_KEY));
        $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        switch ($request->payment_method) {
            case 'payu':
                $payUPayment->execute($user, $txnId, $payablePrice, $productInfo);
                break;
            case 'paypal':
                $provider = new PayPal();
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('payment.success'),
                        "cancel_url" => route('payment.failure'),
                    ],
                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => $usd
                            ]
                        ]
                    ]
                ]);

                if (isset($response['id']) && $response['id'] != null) {

                    foreach ($response['links'] as $links) {
                        if ($links['rel'] == 'approve') {
                            return redirect()->away($links['href']);
                        }
                    }

                    return redirect()
                        ->route('cancel.payment')
                        ->with('error', 'Something went wrong.');
                } else {
                    return redirect()
                        ->route('create.payment')
                        ->with('error', $response['message'] ?? 'Something went wrong.');
                }
                break;
            case 'stripe':
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                $session = CheckoutSession::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => $productInfo,
                                ],
                                'unit_amount' => $usd,
                            ],
                            'quantity' => 1,
                        ]
                    ],
                    'mode' => 'payment',
                    'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('payment.failure'),
                ]);
                return redirect($session->url);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
    }

    public function success(Request $request, PaymentResponse $paymentResponse)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');
        try {
            $session = CheckoutSession::retrieve($sessionId);
            if ($session->payment_status === 'paid') {
                dd($session);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        $paymentResponse->execute($request, $order);
        return view('pages.payment-success', compact('order'));
    }

    public function failure(Request $request, PaymentResponse $paymentResponse)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');
        try {
            $session = CheckoutSession::retrieve($sessionId);
            if ($session->payment_status === 'paid') {
                dd($session);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        $paymentResponse->execute($request, $order);
        return view('pages.payment-failure', compact('order'));
    }
}
