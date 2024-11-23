<?php

namespace App\Models;

use App\Events\MeetingCredentialsUpdatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Schedule extends Model
{
    protected $fillable = [
        'course_id',
        'start_date',
        'time',
        'end_time',
        'duration',
        'duration_type',
        'day_off',
        'training_mode',
        'zoom_meeting_url',
        'meeting_id',
        'meeting_password'
    ];

    protected $casts = [
        'day_off' => 'array',
        'start_date' => 'datetime',
        'time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function orderSchedule(): HasOneThrough
    {
        return $this->hasOneThrough(OrderSchedule::class, Order::class);
    }

    public static function deletePastSchedules()
    {
        self::whereDate('start_date', '<', today())->delete();
    }

    protected static function booted()
    {
        static::updated(function ($schedule) {
            if ($schedule->isDirty(['zoom_meeting_url', 'meeting_id', 'meeting_password'])) {
                event(new MeetingCredentialsUpdatedEvent($schedule));
            }
        });
    }
}
