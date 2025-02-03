<?php

namespace App\Console\Commands;

use App\Mail\AttendingCertificateMail;
use App\Models\Certificate;
use App\Models\Schedule;
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
        $schedules = Schedule::where('certificate_status', false)->get();
        foreach ($schedules as $schedule) {
            $startDate = Carbon::parse($schedule->start_date)->subDays(1);
            $duration = $schedule->duration;
            $durationType = $schedule->duration_type;
            switch ($durationType) {
                case 'Day':
                    $endDate = $startDate->addDays($duration);
                    break;
                case 'Week':
                    $endDate = $startDate->addWeeks($duration);
                    break;
                case 'Month':
                    $endDate = $startDate->addMonths($duration);
                    break;
                default:
                    $endDate = null;
                    break;
            }

            if ($endDate->lt($today)) {
                $orderSchedules = $schedule->orderSchedule;
                foreach ($orderSchedules as $orderSchedule) {
                    $order = $orderSchedule->order;
                    $user = $order->user;
                    $userName = $user->name;
                    $userEmail = $user->email;
                    $courseName = $orderSchedule->schedule->course->name;
                    $batchDate = $schedule->start_date;
                    $receiptNo = $order->payment->receipt_number;

                    $data = [
                        'userName' => $userName,
                        'courseName' => $courseName,
                        'batchDate' => $batchDate,
                        'endDate' => $endDate,
                        'receiptNo' => $receiptNo,
                    ];
                    $pdf = Pdf::loadView('pages.attendance-certificate', $data)->setOption(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
                    $pdfFileName = 'certificates/certificate_' . time() . '.pdf';
                    $pdfPath = public_path($pdfFileName);
                    $pdf->save($pdfPath);
                    $certificate = new Certificate([
                        'course_name' => $courseName,
                        'certificate_path' => $pdfFileName,
                    ]);
                    $user->certificates()->save($certificate);

                    $subject = 'Course Completion Certificate';
                    Mail::to($userEmail)->send(new AttendingCertificateMail($pdfFileName, $subject, $userName, $courseName));
                }
                $schedule->update(['certificate_status' => true]);
            }
        }
    }
}
