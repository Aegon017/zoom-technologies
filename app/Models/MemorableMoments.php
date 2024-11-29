<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemorableMoments extends Model
{
    protected $fillable = [
        'image',
        'image_alt',
        'content',
    ];
}
