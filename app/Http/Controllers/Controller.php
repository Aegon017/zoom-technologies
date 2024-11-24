<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
}

// <?php

// namespace App\Http\Controllers;

// use App\Mail\AdminMail;
// use App\Mail\MeetingMail;
// use App\Mail\OrderMail;
// use App\Models\Order;
// use App\Models\Course;
// use App\Models\Package;
// use App\Models\OrderSchedule;
// use App\Models\Schedule;
// use App\Models\Tax;
// use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Arr;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;

// class PaymentController extends Controller
// {
//     protected $cgst;
//     protected $sgst;

//     public function __construct()
//     {
//         $this->cgst = Tax::where('name', 'CGST')->first()->rate ?? 0;
//         $this->sgst = Tax::where('name', 'SGST')->first()->rate ?? 0;
//     }

//     public function initiatePayment(Request $request)
//     {
//         $data = $this->preparePaymentData($request);
//         return view('pages.payment-initiate', compact('data'));
//     }

//     public function preparePaymentData(Request $request): array
//     {
//         $courseSchedules = $this->getCourseSchedulesFromRequest($request);
//         Session::put('courseSchedules', $courseSchedules);

//         $txnid = uniqid();
//         return [
//             'key' => config('services.payu.key'),
//             'txnid' => $txnid,
//             'amount' => $request->amount,
//             'productinfo' => $request->name,
//             'firstname' => Auth::user()->name,
//             'email' => Auth::user()->email,
//             'phone' => Auth::user()->phone,
//             'surl' => route('payment.success'),
//             'furl' => route('payment.failure'),
//             'udf1' => $request->product_type,
//             'hash' => $this->generateHash($txnid, $request->amount, $request->name, $request->product_type),
//         ];
//     }

//     private function getCourseSchedulesFromRequest(Request $request): array
//     {
//         return array_values(Arr::where($request->all(), fn($value, $key) => str_starts_with($key, 'course_schedule')));
//     }

//     public function generateHash($txnid, $amount, $productinfo, $udf1): string
//     {
//         $hashSequence = $this->createHashSequence($txnid, $amount, $productinfo, $udf1);
//         return strtolower(hash('sha512', $hashSequence));
//     }

//     public function createHashSequence($txnid, $amount, $productinfo, $udf1): string
//     {
//         $key = config('services.payu.key');
//         $salt = config('services.payu.salt');
//         $firstname = Auth::user()->name;
//         $email = Auth::user()->email;
//         return implode('|', [
//             $key,
//             $txnid,
//             $amount,
//             $productinfo,
//             $firstname,
//             $email,
//             $udf1,
//             '',
//             '',
//             '',
//             '',
//             '',
//             '',
//             '',
//             '',
//             '',
//             $salt
//         ]);
//     }

//     public function paymentSuccess(Request $request)
//     {
//         return $this->handlePaymentResponse($request, 'success');
//     }

//     public function paymentFailure(Request $request)
//     {
//         return $this->handlePaymentResponse($request, 'failure');
//     }

//     public function handlePaymentResponse(Request $request, string $status)
//     {
//         $order = $this->findOrCreateOrder($request);
//         $order->save();
//         if ($order->status == 'success') {
//             $order->invoice = $this->generateInvoice($order);
//         }
//         $this->attachSchedulesToOrder($order);
//         $this->sendOrderEmails($order);

//         return view("pages.payment-$status", compact('order'));
//     }

//     public function findOrCreateOrder(Request $request): Order
//     {
//         $totalPrice = $request->amount;
//         $coursePrice = $totalPrice / (1 + ($this->sgst + $this->cgst) / 100);
//         $sgst = $coursePrice * ($this->sgst / 100);
//         $cgst = $coursePrice * ($this->cgst / 100);

//         $model = $this->getModelFromProductType($request->udf1);
//         $item = $model::where('slug', $request->productinfo)->firstOrFail();

//         return Order::firstOrNew(['transaction_id' => $request->txnid], [
//             'user_id' => Auth::id(),
//             'order_number' => 'zt_' . Auth::id() . now()->format('YmdHis'),
//             'payu_id' => $request->mihpayid,
//             'payment_mode' => $request->mode,
//             'payment_time' => $request->addedon,
//             'payment_desc' => $request->field9,
//             'amount' => $totalPrice,
//             'status' => $request->status,
//             'course_name' => $item->name,
//             'course_thumbnail' => $item->thumbnail,
//             'course_thumbnail_alt' => $item->thumbnail_alt,
//             'course_duration' => $item->duration,
//             'course_duration_type' => $item->duration_type,
//             'courseOrPackage_price' => $coursePrice,
//             'sgst' => $sgst,
//             'cgst' => $cgst,
//         ]);
//     }

//     private function getModelFromProductType(string $productType)
//     {
//         return match ($productType) {
//             'course' => Course::class,
//             'package' => Package::class,
//             default => throw new \InvalidArgumentException("Unknown product type: $productType"),
//         };
//     }

//     private function attachSchedulesToOrder(Order $order): void
//     {
//         $schedulesId = Session::get('courseSchedules');
//         foreach ($schedulesId as $scheduleId) {
//             $schedule = Schedule::find($scheduleId);
//             $orderSchedule = new OrderSchedule([
//                 'order_id' => $order->id,
//                 'course_name' => $schedule->course->name,
//                 'start_date' => $schedule->start_date,
//                 'time' => $schedule->time,
//                 'end_time' => $schedule->end_time,
//                 'duration' => $schedule->duration,
//                 'duration_type' => $schedule->duration_type,
//                 'day_off' => $schedule->day_off,
//                 'training_mode' => $schedule->training_mode,
//                 'zoom_meeting_url' => $schedule->zoom_meeting_url,
//                 'meeting_id' => $schedule->meeting_id,
//                 'meeting_password' => $schedule->meeting_password,
//             ]);
//             $orderSchedule->save();
//         }
//     }

//     public function generateInvoice(Order $order): string
//     {
//         $data = ['order' => $order];
//         $pdf = FacadePdf::loadView('pages.invoice', $data);
//         $pdfFileName = 'invoices/invoice_' . time() . '.pdf';
//         $pdfPath = public_path($pdfFileName);
//         $pdf->save($pdfPath);
//         return $pdfFileName;
//     }

//     public function sendOrderEmails(Order $order): void
//     {
//         $to = $order->user->email;
//         $subject = "Payment {$order->status} on your order with Zoom Technologies";
//         Mail::to($to)->send(new OrderMail($subject, $order));

//         if ($order->status === 'success') {
//             $adminEmail = 'kondanagamalleswararao016@gmail.com';
//             Mail::to($adminEmail)->send(new AdminMail("New Enrollment", $order));
//             Mail::to($to)->send(new MeetingMail($order));
//         }
//     }
// }
