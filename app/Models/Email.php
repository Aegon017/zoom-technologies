<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Email extends Model
{
    protected $fillable = [
        'email',
    ];

    public function stickyContact(): HasOne
    {
        return $this->hasOne(StickyContact::class);
    }
}
