<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'receipt_number',
        'coupon_id',
        'payment_id',
        'method',
        'mode',
        'description',
        'date',
        'time',
        'status',
        'amount',
        'currency',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function getTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
