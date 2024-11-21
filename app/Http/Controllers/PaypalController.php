<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaypalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        $this->apiContext->setConfig([
            'mode' => 'sandbox',
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'DEBUG',
            'cache.enabled' => true,
        ]);
    }

    public function initiatePayment(Request $request)
    {
        // dd($request->all());
        // Save course schedule in the session
        Session::put('course_schedule', $request->course_schedule);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->amount);
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($request->name);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'))
            ->setCancelUrl(route('payment.failure'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (\Exception $ex) {
            return back()->withErrors('Something went wrong with the payment.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        // dd($request->all());
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');

        // Retrieve course_schedule from session
        $course_schedule = Session::get('course_schedule');
        Session::forget('course_schedule'); // Clear it from session after use

        try {
            $payment = Payment::get($paymentId, $this->apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);
            $result = $payment->execute($execution, $this->apiContext);

            $transaction = $result->getTransactions()[0];
            $relatedResources = $transaction->getRelatedResources();

            $txnId = null;
            $status = 'unknown';
            foreach ($relatedResources as $resource) {
                if ($resource->getSale()) {
                    $sale = $resource->getSale();
                    $txnId = $sale->getId();
                    $status = $sale->getState(); // Capture the status here (e.g., "completed", "pending", "on hold")
                    break;
                }
            }

            if (!$txnId) {
                \Log::error('Transaction ID not found in related resources');
                return redirect()->route('payment.failure')->withErrors('Transaction ID not found.');
            }

            // Store order in the database with the correct status
            $order = Orders::create([
                'user_id' => auth()->id(),
                'course_name' => $transaction->getDescription(),
                'course_schedule' => $course_schedule,
                'course_price' => $transaction->getAmount()->getTotal(),
                'status' => $status, // Save the actual status here
                'payment_mode' => 'paypal',
                'txn_id' => $txnId,
            ]);

            return view('frontend.pages.payment.success', compact('order'));
        } catch (\Exception $ex) {
            \Log::error('Payment execution failed: ' . $ex->getMessage());
            return redirect()->route('payment.failure')->withErrors('Payment failed. Please try again.');
        }
    }

    public function paymentFailure(Request $request)
    {
        // Retrieve course schedule, name, and price if previously stored
        $course_schedule = Session::get('course_schedule', 'N/A');
        $course_name = $request->input('course_name', 'Unknown Course');
        $course_price = $request->input('amount', 0); // Retrieve the actual course price
        $txnId = $request->input('paymentId', 'N/A'); // Transaction ID if available

        // Create a failed order entry with the actual price
        $order = Orders::create([
            'user_id' => auth()->id(),
            'course_name' => $course_name,
            'course_schedule' => $course_schedule,
            'course_price' => $course_price, // Use actual price even if the transaction failed
            'status' => 'failed',
            'payment_mode' => 'paypal',
            'txn_id' => $txnId,
        ]);

        // Clear session data after usage
        Session::forget('course_schedule');

        // Pass the order to the failure view
        return view("frontend.pages.payment.failure", compact('order'));
    }
}
