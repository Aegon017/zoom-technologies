<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function () {
            self::deletePastSchedules();
        });

        static::updating(function () {
            self::deletePastSchedules();
        });
    }

    protected static function deletePastSchedules()
    {
        self::whereDate('start_date', '<', Carbon::today())->delete();
    }

    protected $fillable = [
        'course_id',
        'start_date',
        'time',
        'duration',
        'duration_type',
        'daily_hours',
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
}
