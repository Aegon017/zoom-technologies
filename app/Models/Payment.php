<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'method',
        'mode',
        'description',
        'date',
        'time',
        'status',
        'amount',
    ];

    protected $casts = [
        'time' => 'datetime',
        'date' => 'datetime'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}