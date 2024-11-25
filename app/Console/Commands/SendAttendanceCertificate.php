<?php

namespace App\Console\Commands;

use App\Mail\AttendingCertificateMail;
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
        $students = [];
        $data = [];
        $schedules = Schedule::where('start_date', '<', $today)->get();
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
                    $endDate = $startDate;
                    break;
            }
            if ($endDate->lt($today)) {

                $order = $schedule->orderSchedule->order;
                $userName = $order->user->name;
                $userEmail = $order->user->email;
                $courseName = $order->course->name;
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
                $subject = 'Certificate of Attendance';
                Mail::to($data['userEmail'])->send(new AttendingCertificateMail($pdfFileName, $subject));
            }
        }
    }
}
