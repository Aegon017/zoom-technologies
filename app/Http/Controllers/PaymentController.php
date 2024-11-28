<?php

namespace App\Http\Controllers;

use App\Actions\Payment\AttachScheduleToOrder;
use App\Actions\Payment\CreateOrder;
use App\Actions\Payment\GenerateInvoice;
use App\Actions\Payment\PaymentResponse;
use App\Actions\Payment\SendEmails;
use App\Actions\Payment\UpdateOrderPayment;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Usd;
use App\Services\PayUPayment;
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
        Session::put('paymentMethod', $request->payment_method);
        $paymentMethod = Session::get('paymentMethod');
        $user = Auth::user();
        $usd_rate = Currency::where('name', 'USD')->first()->value;
        $txnId = uniqid();
        $payablePrice = $request->payable_price;
        $productInfo = $request->name;
        $usd = round(($payablePrice / $usd_rate), 0);
        Session::put('usd', $usd);
        $order = $createOrder->execute($request, $user->id, $usd);
        Session::put('order_id', $order->id);
        $scheduleIDs = array_values(array_filter($request->all(), fn($key) => str_starts_with($key, 'course_schedule'), ARRAY_FILTER_USE_KEY));
        $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        switch ($paymentMethod) {
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
                        [
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
                } else {
                    return redirect()
                        ->route('/')
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
                                'unit_amount' => $usd * 100,
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
        $paymentMethod = Session::get('paymentMethod');
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        switch ($paymentMethod) {
            case 'payu':
                $paymentResponse->execute($request, $order);
                break;

            case 'paypal':
                $provider = new PayPal();
                $provider->setApiCredentials(config('paypal'));
                $provider->getAccessToken();
                $response = $provider->capturePaymentOrder($request->token);
                $paymentId = $response['purchase_units'][0]['payments']['captures'][0]['id'];
                $method = 'paypal';
                $mode = 'Card';
                $description = 'Payment success';
                $date = today();
                $time = now();
                $status = 'success';
                $amount = Session::get('usd');
                $generateInvoice = new GenerateInvoice();
                $sendEmails = new SendEmails();
                $updateOrderPayment = new UpdateOrderPayment();
                $data = [
                    'paymentId' => $paymentId,
                    'method' => $method,
                    'mode' => $mode,
                    'description' => $description,
                    'date' => $date,
                    'time' => $time,
                    'status' => $status,
                    'amount' => $amount,
                    'currency' => 'USD',
                ];
                $updateOrderPayment->execute($order->id, $data);
                $order->invoice = $generateInvoice->execute($order);
                $order->save();
                $sendEmails->execute($order);
                break;

            case 'stripe':
                $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
                $response = $stripe->checkout->sessions->retrieve($request->session_id);
                $paymentId = $response->payment_intent;
                $method = 'stripte';
                $mode = 'Card';
                $description = 'Payment success';
                $date = today();
                $time = now();
                $status = 'success';
                $amount = Session::get('usd');
                $generateInvoice = new GenerateInvoice();
                $sendEmails = new SendEmails();
                $updateOrderPayment = new UpdateOrderPayment();
                $data = [
                    'paymentId' => $paymentId,
                    'method' => $method,
                    'mode' => $mode,
                    'description' => $description,
                    'date' => $date,
                    'time' => $time,
                    'status' => $status,
                    'amount' => $amount,
                    'currency' => 'USD',
                ];
                $updateOrderPayment->execute($order->id, $data);
                $order->invoice = $generateInvoice->execute($order);
                $order->save();
                $sendEmails->execute($order);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
        return view('pages.payment-success', compact('order'));
    }

    public function failure(Request $request, PaymentResponse $paymentResponse)
    {
        $paymentMethod = Session::get('paymentMethod');
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        switch ($paymentMethod) {
            case 'payu':
                $paymentResponse->execute($request, $order);
                break;
            case 'paypal':
                $provider = new PayPal();
                $provider->setApiCredentials(config('paypal'));
                $provider->getAccessToken();
                $response = $provider->capturePaymentOrder($request->token);
                $paymentId = 'N/A';
                $method = 'paypal';
                $mode = 'N/A';
                $description = 'Payment failure';
                $date = today();
                $time = now();
                $status = 'failure';
                $amount = Session::get('usd');
                $sendEmails = new SendEmails();
                $updateOrderPayment = new UpdateOrderPayment();
                $data = [
                    'paymentId' => $paymentId,
                    'method' => $method,
                    'mode' => $mode,
                    'description' => $description,
                    'date' => $date,
                    'time' => $time,
                    'status' => $status,
                    'amount' => $amount,
                    'currency' => 'USD',
                ];
                $updateOrderPayment->execute($order->id, $data);
                $sendEmails->execute($order);
                break;

            case 'stripe':
                $paymentId = 'N/A';
                $method = 'stripe';
                $mode = 'N/A';
                $description = 'Payment failure';
                $date = today();
                $time = now();
                $status = 'failure';
                $amount = Session::get('usd');
                $sendEmails = new SendEmails();
                $updateOrderPayment = new UpdateOrderPayment();
                $data = [
                    'paymentId' => $paymentId,
                    'method' => $method,
                    'mode' => $mode,
                    'description' => $description,
                    'date' => $date,
                    'time' => $time,
                    'status' => $status,
                    'amount' => $amount,
                    'currency' => 'USD',
                ];
                $updateOrderPayment->execute($order->id, $data);
                $sendEmails->execute($order);
                break;

            default:
                echo 'Please choose a valid payment method';
                break;
        }
        return view('pages.payment-failure', compact('order'));
    }
}
