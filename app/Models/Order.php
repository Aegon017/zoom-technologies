<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'transaction_id',
        'payu_id',
        'payment_mode',
        'payment_time',
        'payment_desc',
        'amount',
        'status',
        'invoice',
        'course_name',
        'course_thumbnail',
        'course_thumbnail_alt',
        'course_duration',
        'course_duration_type',
        'course_price',
        'sgst',
        'cgst',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function orderSchedule(): HasMany
    {
        return $this->hasMany(OrderSchedule::class);
    }
}
