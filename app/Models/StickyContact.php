<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StickyContact extends Model
{
    protected $fillable = [
        'mobile_number_id',
        'email_id',
    ];

    public function mobileNumber(): BelongsTo
    {
        return $this->belongsTo(MobileNumber::class);
    }

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }
}
