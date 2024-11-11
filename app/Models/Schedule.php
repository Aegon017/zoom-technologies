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
        'training_mode'
    ];

    protected $casts = [
        'day_off' => 'array',
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
