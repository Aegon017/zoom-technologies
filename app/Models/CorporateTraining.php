<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateTraining extends Model
{
    protected $fillable = [
        'image',
        'image_alt',
        'redirect_url',
    ];
}
