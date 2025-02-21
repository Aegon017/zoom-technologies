<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MobileNumber extends Model
{
    protected $fillable = ['number'];

    public function stickyContact(): HasOne
    {
        return $this->hasOne(StickyContact::class);
    }
}
