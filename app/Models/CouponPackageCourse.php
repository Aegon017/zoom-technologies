<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponPackageCourse extends Model
{
    protected $fillable = [
        'coupon_id',
        'package_id'
    ];
}
