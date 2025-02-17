<?php

namespace App\Models;

use App\Events\ManualOrderCreatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualOrder extends Model
{
    protected $fillable = [
        'is_registered',
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'user_image',
        'user_id_card',
        'course_id',
        'package_id',
        'schedule_id',
        'packageSchedule_id',
        'course_price',
        'cgst',
        'sgst',
        'amount',
        'payment_mode',
        'proof',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'enrolled_by',
    ];

    protected $casts = [
        'packageSchedule_id' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
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
