<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'course_id',
        'package_id',
        'product_type',
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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'coupon_courses');
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'coupon_package_courses');
    }
}
