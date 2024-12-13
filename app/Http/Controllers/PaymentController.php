<?php

namespace App\Http\Controllers;

use App\Actions\Payment\AttachScheduleToOrder;
use App\Actions\Payment\CreateOrder;
use App\Actions\Payment\GenerateInvoice;
use App\Actions\Payment\PaymentResponse;
use App\Actions\Payment\SendEmails;
use App\Actions\Payment\UpdateOrderPayment;
use App\Models\Address;
use App\Models\Currency;
use App\Models\Thankyou;
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
    public function initiate(Request $request)
    {
        $user = Auth::user();
        $payablePrice = $request->payable_price;
        $productType = $request->product_type;
        $productInfo = $request->name;
        $selectedAddress = $request->selected_address;
        $scheduleIDs = Session::get('scheduleIDs');
        Session::put('paymentMethod', $request->payment_method);
        Session::put('userID', $user->id);
        Session::put('scheduleIDs', $scheduleIDs);
        session::put('productName', $productInfo);
        Session::put('payablePrice', $payablePrice);
        Session::put('productType', $productType);
        Session::put('selectedAddress', $selectedAddress);
        switch ($request->payment_method) {
            case 'payu':
                $txnId = uniqid();
                $payUPayment = new PayUPayment;
                $payUPayment->execute($user, $txnId, $payablePrice, $productInfo);
                break;
            case 'paypal':
                $provider = new PayPal;
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();
                $usd_rate = Currency::where('name', 'USD')->first()->value;
                $usd = ceil($payablePrice / $usd_rate);
                Session::put('usd', $usd);
                $response = $provider->createOrder([
                    'intent' => 'CAPTURE',
                    'application_context' => [
                        'return_url' => route('payment.success'),
                        'cancel_url' => route('payment.failure'),
                    ],
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => $usd,
                            ],
                        ],
                    ],
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
                $usd_rate = Currency::where('name', 'USD')->first()->value;
                $usd = ceil($payablePrice / $usd_rate);
                Session::put('usd', $usd);
                $checkoutSession = CheckoutSession::create([
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
                        ],
                    ],
                    'mode' => 'payment',
                    'success_url' => route('payment.success').'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('payment.failure'),
                ]);

                return redirect($checkoutSession->url);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
    }

    public function success(Request $request)
    {
        $createOrder = new CreateOrder;
        $attachScheduleToOrder = new AttachScheduleToOrder;
        $paymentResponse = new PaymentResponse;
        $paymentMethod = Session::get('paymentMethod');
        $userID = Session::get('userID');
        $usd = Session::get('usd');
        $scheduleIDs = Session::get('scheduleIDs');
        $order = $createOrder->execute($userID, $usd);
        $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        $thankyou = Thankyou::first();
        switch ($paymentMethod) {
            case 'payu':
                $paymentResponse->execute($request, $order);
                break;
            case 'paypal':
                $provider = new PayPal;
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
                $generateInvoice = new GenerateInvoice;
                $sendEmails = new SendEmails;
                $updateOrderPayment = new UpdateOrderPayment;
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
                $selectedAddress = Session::get('selectedAddress');
                $address = Address::where('user_id', $userID)->first();
                $order->invoice = $generateInvoice->execute($order, $address);
                $order->save();
                $sendEmails->execute($order);
                break;

            case 'stripe':
                $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
                $response = $stripe->checkout->sessions->retrieve($request->session_id);
                $paymentId = $response->payment_intent;
                $method = 'stripe';
                $mode = 'Card';
                $description = 'Payment success';
                $date = today();
                $time = now();
                $status = 'success';
                $amount = Session::get('usd');
                $generateInvoice = new GenerateInvoice;
                $sendEmails = new SendEmails;
                $updateOrderPayment = new UpdateOrderPayment;
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
                $address = Address::where('user_id', $userID)->first();
                $order->invoice = $generateInvoice->execute($order, $address);
                $order->save();
                $sendEmails->execute($order);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }

        return view('pages.payment-success', compact('order', 'thankyou'));
    }

    public function failure(Request $request)
    {
        $createOrder = new CreateOrder;
        $attachScheduleToOrder = new AttachScheduleToOrder;
        $paymentResponse = new PaymentResponse;
        $paymentMethod = Session::get('paymentMethod');
        $userID = Session::get('userID');
        $usd = Session::get('usd');
        $scheduleIDs = Session::get('scheduleIDs');
        $order = $createOrder->execute($userID, $usd);
        $attachScheduleToOrder->execute($scheduleIDs, $order->id);
        switch ($paymentMethod) {
            case 'payu':
                $paymentResponse->execute($request, $order);
                break;
            case 'paypal':
                $provider = new PayPal;
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
                $sendEmails = new SendEmails;
                $updateOrderPayment = new UpdateOrderPayment;
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
                $sendEmails = new SendEmails;
                $updateOrderPayment = new UpdateOrderPayment;
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
        }

        return view('pages.payment-failure', compact('order'));
    }
}
