<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'payment_method',
        'status',
        'payment_id',
        'payment_time',
        'payment_desc',
        'amount',
        'invoice',
        'course_name',
        'course_thumbnail',
        'course_thumbnail_alt',
        'course_duration',
        'course_duration_type',
        'course_price',
        'sgst',
        'cgst'
    ];

    protected $casts = [
        'payment_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function orderSchedule(): HasMany
    {
        return $this->hasMany(OrderSchedule::class);
    }
}
