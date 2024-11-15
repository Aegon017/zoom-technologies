<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StickyContact extends Model
{
    protected $fillable = [
        'mobile',
        'email'
    ];

    protected $casts = [
        'mobile' => 'array',
        'email' => 'array'
    ];
}
