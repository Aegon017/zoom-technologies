<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyMaterial extends Model
{
    protected $fillable = [
        'course_id',
        'name',
        'image',
        'image_alt',
        'material_url',
        'subscription'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
