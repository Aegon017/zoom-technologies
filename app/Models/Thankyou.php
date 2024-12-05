<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thankyou extends Model
{
    protected $fillable = [
        'title',
        'content',
        'heading',
        'sub_heading',
        'email',
        'mobile',
    ];

    protected $casts = [
        'email' => 'array',
        'mobile' => 'array',
    ];
}
