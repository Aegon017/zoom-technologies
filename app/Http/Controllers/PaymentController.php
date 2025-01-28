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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use PhonePe\payments\v1\PhonePePaymentClient;
use Srmklive\PayPal\Services\PayPal;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        Session::put('refresh', true);
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
                $currency = Currency::where('name', 'USD')->first();
                if ($currency) {
                    $usd_rate = $currency->value;
                } else {
                    $response = Http::get('https://api.coinbase.com/v2/exchange-rates?currency=USD');
                    $data = $response->json();
                    $usd_rate = $data['data']['rates']['INR'];
                }
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
                $response = Http::get('https://api.coinbase.com/v2/exchange-rates?currency=USD');
                $data = $response->json();
                $usd_rate = $data['data']['rates']['INR'];
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
                    'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('payment.failure'),
                ]);

                return redirect($checkoutSession->url);
                break;
            case 'phonepe':
                $merchantID = config('services.phonepe.merchant_id');
                $saltKey = config('services.phonepe.salt_key');
                $saltIndex = config('services.phonepe.salt_index');
                $environment = config('services.phonepe.environment');
                $shouldPublishEvents = config('services.phonepe.should_publish_events');
                $phonePePaymentsClient = new PhonePePaymentClient($merchantID, $saltKey, $saltIndex, $environment, $shouldPublishEvents);

                $merchantTransactionId = 'PHPSDK' . date("ymdHis") . "payPageTest";
                $request = PgPayRequestBuilder::builder()
                    ->mobileNumber("9381480023")
                    ->callbackUrl(route('phonepe.callback'))
                    ->merchantId($merchantID)
                    ->merchantUserId("123456")
                    ->amount($payablePrice * 100)
                    ->merchantTransactionId($merchantTransactionId)
                    ->redirectUrl(route('payment.success'))
                    ->redirectMode("POST")
                    ->paymentInstrument(InstrumentBuilder::buildPayPageInstrument())
                    ->build();
                $response = $phonePePaymentsClient->pay($request);
                $url = $response->getInstrumentResponse()->getRedirectInfo()->getUrl();
                return redirect($url);
                break;
            default:
                echo 'Please choose a valid payment method';
                break;
        }
    }

    public function success(Request $request)
    {
        if (Session::get('refresh')) {
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
                case 'phonepe':
                    $merchantID = config('services.phonepe.merchant_id');
                    $saltKey = config('services.phonepe.salt_key');
                    $saltIndex = config('services.phonepe.salt_index');
                    $environment = config('services.phonepe.environment');
                    $shouldPublishEvents = config('services.phonepe.should_publish_events');
                    $phonePePaymentsClient = new PhonePePaymentClient($merchantID, $saltKey, $saltIndex, $environment, $shouldPublishEvents);
                    $response = $phonePePaymentsClient->statusCheck($request->transactionId);
                    $paymentId = $response->getTransactionId();
                    $method = 'phonepe';
                    $mode = 'PhonePe';
                    $description = 'Payment success';
                    $date = today();
                    $time = now();
                    $status = 'success';
                    $amount = $request->amount / 100;
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
                        'currency' => 'Rs',
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
            Session::forget('refresh');

            return view('pages.payment-success', compact('order', 'thankyou'));
        } else {
            return redirect()->route('render.home');
        }
    }

    public function failure(Request $request)
    {
        if (Session::get('refresh')) {
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
            Session::forget('refresh');

            return view('pages.payment-failure', compact('order'));
        } else {
            return redirect()->route('render.home');
        }
    }

    public function phonepeCallback(Request $request)
    {
        Log::info('PhonePe Callback');
    }
}
