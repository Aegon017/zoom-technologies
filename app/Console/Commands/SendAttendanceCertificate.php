<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\Command;


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
        $schedules = Schedule::where('status', false)->where('certificate_status', false)->get();
        foreach ($schedules as $schedule) {
            $startDate = Carbon::parse($schedule->start_date);
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
                    $batchTime = $schedule->time;
                    $trainingMode = $schedule->training_mode;
                    $data = [
                        'userName' => $userName,
                        'courseName' => $courseName,
                        'batchDate' => $batchDate,
                        'batchTime' => $batchTime,
                        'trainingMode' => $trainingMode,
                        'userEmail' => $userEmail,
                    ];
                    $pdf = Pdf::loadView('pages.attendance-certificate', $data);
                    $pdfFileName = 'certificates/certificate_' . time() . '.pdf';
                    $pdfPath = public_path($pdfFileName);
                    $pdf->save($pdfPath);
                    $certificate = new Certificate([
                        'course_name' => $courseName,
                        'certificate_path' => $pdfFileName
                    ]);
                    $user->certificates()->save($certificate);

                    // $subject = 'Course Completion Certificate';
                    // Mail::to($data['userEmail'])->send(new AttendingCertificateMail($pdfFileName, $subject, $userName, $courseName));
                }
                $schedule->update(['certificate_status' => true]);
            }
        }
    }
}
