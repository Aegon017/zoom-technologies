<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Course;
use App\Models\Package;
use PDF;
use App\Mail\OrderMail;
use App\Mail\AdminMail;
use App\Mail\MeetingMail;
use App\Models\Schedule;
use App\Models\Tax;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Hamcrest\Arrays\IsArray as ArraysIsArray;
use Hamcrest\Type\IsArray;
use Illuminate\Support\Arr;

class PaymentController extends Controller
{
    public $zoom_meeting_url;
    public $meeting_id;
    public $meeting_password;
    public function initiatePayment(Request $request)
    {
        $data = $this->preparePaymentData($request);
        return view('pages.payment-initiate', compact('data'));
    }

    private function preparePaymentData(Request $request)
    {
        if ($request->product_type == 'package') {
            $courseSchedules = json_encode(array_values(Arr::where($request->all(), function ($value, $key) {
                return str_starts_with($key, 'course_schedule_');
            })));
        } else {
            $courseSchedules = $request->course_schedule;
        }
        $txnid = uniqid();
        return [
            'key' => config('services.payu.key'),
            'txnid' => $txnid,
            'amount' => $request->amount,
            'productinfo' => $request->name,
            'firstname' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
            'surl' => env('APP_URL') . '/payment/success',
            'furl' => env('APP_URL') . '/payment/failure',
            'udf1' => $courseSchedules,
            'udf2' => $request->product_type,
            'hash' => $this->generateHash($txnid, $request->amount, $request->name, $courseSchedules, $request->product_type),
        ];
    }

    private function generateHash($txnid, $amount, $productinfo, $udf1, $udf2)
    {
        $hashSequence = $this->createHashSequence($txnid, $amount, $productinfo, $udf1, $udf2);
        return strtolower(hash('sha512', $hashSequence));
    }

    private function createHashSequence($txnid, $amount, $productinfo, $udf1, $udf2)
    {
        $key = config('services.payu.key');
        $salt = config('services.payu.salt');
        $firstname = Auth::user()->name;
        $email = Auth::user()->email;
        return implode('|', [
            $key,
            $txnid,
            $amount,
            $productinfo,
            $firstname,
            $email,
            $udf1,
            $udf2,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $salt,
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        return $this->handlePaymentResponse($request, 'success');
    }

    public function paymentFailure(Request $request)
    {
        return $this->handlePaymentResponse($request, 'failure');
    }

    private function handlePaymentResponse(Request $request, $status)
    {
        $order = $this->findOrCreateOrder($request);
        if ($order->status == 'success') {
            $order->invoice = $this->generateInvoice($order);
        }
        $order->save();
        $this->send($order);
        return view("pages.payment-$status", compact('order'));
    }

    private function findOrCreateOrder(Request $request)
    {
        $total_price = $request->amount;
        $course_price = $total_price / (1 + (Tax::where('name', 'SGST')->first()->rate + Tax::where('name', 'CGST')->first()->rate) / 100);
        $sgst = $course_price * (Tax::where('name', 'SGST')->first()->rate / 100);
        $cgst = $course_price * (Tax::where('name', 'CGST')->first()->rate / 100);
        $model = $this->getModelFromProductType($request->udf2);
        $item = $model::where('slug', $request->productinfo)->first();
        $existingOrder = Order::where('transaction_id', $request->txnid)->first();
        if ($existingOrder) {
            return $existingOrder;
        }
        $order = new Order();
        $order->user_id = Auth::id();
        $order->order_number = 'zt_' . Auth::id() . now()->format('YmdHis');
        $order->transaction_id = $request->txnid;
        $order->payu_id = $request->mihpayid;
        $order->payment_mode = $request->mode;
        $order->payment_time = $request->addedon;
        $order->payment_desc = $request->field9;
        $order->amount = $total_price;
        $order->status = $request->status;
        $order->course_name = $item->name;
        $order->course_thumbnail = $item->thumbnail;
        $order->course_thumbnail_alt = $item->thumbnail_alt;
        $order->course_duration = $item->duration;
        $order->course_duration_type = $item->duration_type;
        $order->course_schedule = $request->udf1;
        $order->course_price = $course_price;
        $order->sgst = $sgst;
        $order->cgst = $cgst;
        return $order;
    }

    private function getModelFromProductType($productType)
    {
        return match ($productType) {
            'course' => Course::class,
            'package' => Package::class,
            default => null,
        };
    }

    private function generateInvoice($order)
    {
        $data = [
            'id' => $order->order_number,
            'name' => $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->user->phone,
            'txn_id' => $order->transaction_number,
            'payment_time' => $order->payment_time,
            'payu_id' => $order->payu_id,
            'payment_mode' => $order->payment_mode,
            'course_name' => $order->course_name,
            'course_price' => $order->course_price,
            'course_duration' => $order->course_duration,
            'course_duration_type' => $order->course_duration_type,
            'course_schedule' => $order->course_schedule,
            'sgst' => $order->sgst,
            'cgst' => $order->cgst,
            'total_price' => $order->amount,
        ];

        $pdf = FacadePdf::loadView('pages.invoice', $data);
        $pdfFileName = 'invoices/invoice_' . time() . '.pdf';
        $pdfPath = public_path($pdfFileName);
        $pdf->save($pdfPath);

        return $pdfFileName;
    }

    public function send($order)
    {
        $to = $order->user->email;
        $subject = "Payment " . $order->status . " on your order with Zoom Technologies";
        Mail::to($to)->send(new OrderMail($subject, $order));
        if ($order->status == 'success') {
            $admin = "kondanagamalleswararao016@gmail.com";
            $subject = "New Enrollment";
            $schedules = Schedule::query();
            Mail::to($admin)->send(new AdminMail($subject, $order));
            Mail::to($to)->send(new MeetingMail($order, $schedules));
        }
    }
}
