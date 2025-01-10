<?php

namespace App\Listeners;

use App\Events\MeetingCredentialsUpdatedEvent;
use App\Mail\UpdatedMeetingMail;
use App\Models\OrderSchedule;
use Illuminate\Support\Facades\Mail;

class SendMeetingCredentialsUpdatedEmail
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
    public function handle(MeetingCredentialsUpdatedEvent $event): void
    {
        $subject = 'Updated meeting credentials';
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
                Mail::to($user)->send(new UpdatedMeetingMail($subject, $event->schedule));
            }
        }
    }
}
