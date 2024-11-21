<?php

namespace App\Actions\Payment;

use App\Models\Order;
use App\Models\OrderSchedule;
use App\Models\Schedule;

class AttachScheduleToOrder
{
    public function execute($scheduleIDs, $order_id)
    {
        foreach ($scheduleIDs as $scheduleId) {
            $schedule = Schedule::find($scheduleId);
            $orderSchedule = new OrderSchedule([
                'order_id' => $order_id,
                'course_name' => $schedule->course->name,
                'start_date' => $schedule->start_date,
                'time' => $schedule->time,
                'end_time' => $schedule->end_time,
                'duration' => $schedule->duration,
                'duration_type' => $schedule->duration_type,
                'day_off' => $schedule->day_off,
                'training_mode' => $schedule->training_mode,
                'zoom_meeting_url' => $schedule->zoom_meeting_url,
                'meeting_id' => $schedule->meeting_id,
                'meeting_password' => $schedule->meeting_password,
            ]);
            $orderSchedule->save();
        }
    }
}
