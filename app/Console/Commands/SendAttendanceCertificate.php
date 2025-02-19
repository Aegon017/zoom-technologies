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

        // Fetch orders with successful payments and schedules that haven't issued certificates yet
        $orders = Order::with(['schedule.course', 'user', 'payment'])
            ->whereHas('payment', fn($query) => $query->where('status', 'success'))
            ->whereHas('schedule', fn($query) => $query->where('certificate_status', false))
            ->get();

        foreach ($orders as $order) {
            foreach ($order->schedule as $schedule) {
                $endDate = Carbon::parse($schedule->end_date);

                // Check if the schedule has ended and certificate hasn't been issued
                if ($endDate->lt($today) && !$schedule->certificate_status) {
                    $user = $order->user;
                    $data = [
                        'userName' => $user->name,
                        'courseName' => $schedule->course->name,
                        'batchDate' => $schedule->start_date,
                        'endDate' => $endDate,
                        'receiptNo' => $order->payment->receipt_number,
                        'orderNumber' => $order->order_number,
                    ];

                    // Generate PDF
                    $pdf = Pdf::loadView('pages.attendance-certificate', $data)
                        ->setOption(['defaultFont' => 'sans-serif'])
                        ->setPaper('a4', 'landscape');

                    // Save PDF to storage
                    $pdfFileName = 'certificates/zoom_certificate_' . time() . '_' . $schedule->id . '.pdf';
                    $pdfPath = public_path($pdfFileName);
                    $pdf->save($pdfPath);

                    // Create certificate record
                    $certificate = new Certificate([
                        'schedule_id' => $schedule->id,
                        'certificate_path' => $pdfFileName,
                    ]);
                    $user->certificates()->save($certificate);

                    // Send email
                    $subject = 'Course Completion Certificate';
                    Mail::to($user->email)->send(new AttendingCertificateMail($pdfFileName, $subject, $user->name, $schedule->course->name));

                    // Update schedule certificate status
                    $schedule->update(['certificate_status' => true]);
                }
            }
        }
    }
}
