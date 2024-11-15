<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoSection extends Model
{
    protected $fillable = [
        'title',
        'content',
        'redirect_link'
    ];
}
