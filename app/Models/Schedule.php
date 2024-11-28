<?php

namespace App\Models;

use App\Events\MeetingCredentialsUpdatedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'meeting_password',
        'status',
    ];

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

    public function orderSchedule(): HasOne
    {
        return $this->hasOne(OrderSchedule::class);
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
        return $this->course->name . ' - ' . $this->start_date . ' ' . $this->time . ' - ' . $this->training_mode;
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
