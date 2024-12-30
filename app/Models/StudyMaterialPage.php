<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterialPage extends Model
{
    protected $fillable = [
        'page_content',
    ];

    protected $casts = [
        'page_content' => 'json',
    ];
}
