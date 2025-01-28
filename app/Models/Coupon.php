<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'data',
        'quantity',
        'limit',
        'redeemer_type',
        'redeemer_id',
        'expires_at',
    ];
}
