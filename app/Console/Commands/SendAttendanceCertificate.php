<?php

namespace App\Console\Commands;

use App\Mail\AttendingCertificateMail;
use App\Models\Certificate;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAttendanceCertificate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:send-attendance-certificate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send attending certificate through email notification to students when batch is completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $data = [];
        $orders = Order::with('schedule')
            ->whereHas('payment', function ($query) {
                $query->where('status', 'success');
            })
            ->whereHas('schedule', function ($query) {
                $query->where('certificate_status', false);
            })
            ->get();
        foreach ($orders as $order) {
            $schedules = $order->schedule;
            foreach ($schedules as $schedule) {
                $endDate = Carbon::parse($schedule->end_date);
                if ($endDate->lt($today) && $schedule->certificate_status === false) {
                    $order = $order;
                    $user = $order->user;
                    $userName = $user->name;
                    $userEmail = $user->email;
                    $courseName = $schedule->course->name;
                    $batchDate = $schedule->start_date;
                    $receiptNo = $order->payment->receipt_number;
                    $orderNumber = $order->order_number;

                    $data = [
                        'userName' => $userName,
                        'courseName' => $courseName,
                        'batchDate' => $batchDate,
                        'endDate' => $endDate,
                        'receiptNo' => $receiptNo,
                        'orderNumber' => $orderNumber,
                    ];
                    $pdf = Pdf::loadView('pages.attendance-certificate', $data)->setOption(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
                    $pdfFileName = 'certificates/zoom_certificate_' . time() . '.pdf';
                    $pdfPath = public_path($pdfFileName);
                    $pdf->save($pdfPath);
                    $certificate = new Certificate([
                        'schedule_id' => $schedule->id,
                        'certificate_path' => $pdfFileName,
                    ]);
                    $user->certificates()->save($certificate);
                    $subject = 'Course Completion Certificate';
                    Mail::to($userEmail)->send(new AttendingCertificateMail($pdfFileName, $subject, $userName, $courseName));
                    $schedule->update(['certificate_status' => true]);
                }
            }
        }
    }
}
