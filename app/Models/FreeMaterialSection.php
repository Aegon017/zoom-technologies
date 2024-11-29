<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeMaterialSection extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'content',
        'button_name',
        'redirect_url',
    ];
}
