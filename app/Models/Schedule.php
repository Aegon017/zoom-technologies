<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public static function deletePastSchedules()
    {
        self::whereDate('start_date', '<', Carbon::today())->delete();
    }
}
