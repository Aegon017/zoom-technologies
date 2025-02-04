<?php

namespace App\Models;

use App\Events\MeetingCredentialsUpdatedEvent;
use App\Events\ScheduleDeleted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Schedule extends Model
{
    use SoftDeletes;

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
        self::whereDate('start_date', '<', today()->subDays(5))->update(['status' => false]);
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

        static::deleted(function ($schedule) {
            Log::info($schedule);
            event(new ScheduleDeleted($schedule));
        });
    }

    public function manualOrder(): HasMany
    {
        return $this->hasMany(ManualOrder::class);
    }

    public function getFormattedScheduleAttribute()
    {
        $timezone = Timezone::find($this->timezone_id);
        $offset = $timezone->offset;
        $abbreviation = $timezone->abbreviation;

        return $this->start_date . ', ' . $this->time . ' ( ' . $abbreviation . ' - ' . $offset . ' )';
    }

    public function getFormattedPackageScheduleAttribute()
    {
        $timezone = Timezone::find($this->timezone_id);
        $offset = $timezone->offset;
        $abbreviation = $timezone->abbreviation;

        return $this->course->name . ' - ' . $this->start_date . ', ' . $this->time . ' ( ' . $abbreviation . ' - ' . $offset . ' )' . ' - ' . $this->training_mode;
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

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
