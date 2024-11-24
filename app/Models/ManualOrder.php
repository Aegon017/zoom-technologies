<?php

namespace App\Models;

use App\Events\ManualOrderCreatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualOrder extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'package_id',
        'schedule_id',
        'course_price',
        'cgst',
        'sgst',
        'amount',
        'payment_mode'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }

    protected static function booted()
    {
        static::created(function ($manualOrder) {
            if ($manualOrder) {
                event(new ManualOrderCreatedEvent($manualOrder));
            }
        });
    }
}
