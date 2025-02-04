<?php

namespace App\Actions;

use App\Mail\AttendingCertificateMail;
use App\Models\Certificate;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class SendCertificate
{
    public function execute(Collection $orderSchedules)
    {
        $today = Carbon::today();
        $data = [];
        foreach ($orderSchedules as $orderSchedule) {
            $schedule = $orderSchedule->schedule;
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
                Notification::make()
                    ->title('Certificate sent successfully')
                    ->body('The certificate for the course <strong>' . $courseName . '</strong> has been sent to <strong>' . $userName . '</strong>.')
                    ->success()
                    ->send();
            } else {
                $courseName = $orderSchedule->schedule->course->name;
                Notification::make()
                    ->title('Course not completed')
                    ->body('The course <strong>' . $courseName . '</strong> has not been completed yet.')
                    ->danger()
                    ->send();
            }
        }
    }
}
