<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'invoice'
    ];

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
