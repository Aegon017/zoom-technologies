<?php

namespace App\Listeners;

use App\Events\MeetingCredentialsUpdatedEvent;
use App\Mail\MeetingMail;
use App\Mail\UpdatedMeetingMail;
use App\Models\OrderSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        $user = 'kondanagamalleswararao016@gmail.com';
        $scheduleId = $event->schedule->id;
        $orderSchedules = OrderSchedule::where('schedule_id', $scheduleId)->get();
        foreach ($orderSchedules as $orderSchedule) {
            if ($orderSchedule->order->status == 'success') {
                $users[$orderSchedule->order->user->name] = $orderSchedule->order->user->email;
            }
        }
        foreach ($users as $user) {
            Mail::to($user)->send(new UpdatedMeetingMail($subject, $event->schedule));
        }
    }
}
