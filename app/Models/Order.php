<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'package_id',
        'payment_id',
        'order_number',
        'courseOrPackage_price',
        'cgst',
        'sgst',
        'invoice',
        'enrolled_by',
    ];

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderSchedule(): HasMany
    {
        return $this->hasMany(OrderSchedule::class);
    }

    public function schedule()
    {
        return $this->hasManyThrough(Schedule::class, OrderSchedule::class, 'order_id', 'id', 'id', 'schedule_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function getFormattedStartDateAttribute()
    {
        return \Carbon\Carbon::parse($this->start_date)->format('Y-m-d');
    }
}
