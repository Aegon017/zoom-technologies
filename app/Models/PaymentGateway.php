<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'gateway',
    ];

    protected $casts = [
        'gateway' => 'array',
    ];
}
