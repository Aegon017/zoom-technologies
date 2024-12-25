<?php

namespace App\Models;

use App\Events\MeetingCredentialsUpdatedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'course_id',
        'timezone_id',
        'start_date',
        'time',
        'end_time',
        'duration',
        'duration_type',
        'day_off',
        'training_mode',
        'zoom_meeting_url',
        'meeting_id',
        'meeting_password',
        'status',
        'certificate_status',
    ];

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class);
    }

    protected static function expireSchedule()
    {
        self::whereDate('start_date', '<', today())
            ->update(['status' => false]);
    }

    protected $casts = [
        'day_off' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function orderSchedule(): HasMany
    {
        return $this->hasMany(OrderSchedule::class);
    }

    protected static function booted()
    {

        static::updated(function ($schedule) {
            if ($schedule->isDirty(['zoom_meeting_url', 'meeting_id', 'meeting_password'])) {
                event(new MeetingCredentialsUpdatedEvent($schedule));
            }
        });
    }

    public function manualOrder(): HasMany
    {
        return $this->hasMany(ManualOrder::class);
    }

    public function getFormattedScheduleAttribute()
    {
        return $this->start_date . ', ' . $this->time;
    }

    public function getFormattedPackageScheduleAttribute()
    {
        return $this->course->name . ' - ' . $this->start_date . ', ' . $this->time;
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function getTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }
}
