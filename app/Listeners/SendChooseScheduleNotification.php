<?php

namespace App\Listeners;

use App\Events\ScheduleDeleted;
use App\Mail\DeletedSheduleMail;
use App\Mail\ScheduleDeletedMail;
use App\Models\OrderSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendChooseScheduleNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ScheduleDeleted $event): void
    {
        $subject = 'Class Cancellation Notification';
        $scheduleId = $event->schedule->id;
        $orderSchedules = OrderSchedule::where('schedule_id', $scheduleId)->get();
        $users = [];
        foreach ($orderSchedules as $orderSchedule) {
            if ($orderSchedule->order->payment->status == 'success') {
                $users[$orderSchedule->order->user->name] = $orderSchedule->order->user->email;
            }
        }
        if ($users) {
            foreach ($users as $user) {
                Mail::to($user)->send(new ScheduleDeletedMail($subject, $event->schedule));
            }
        }
    }
}
