<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderSchedule extends Model
{
    protected $fillable = [
        'order_id',
        'schedule_id',
        'course_name',
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
