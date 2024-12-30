<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleCertificate extends Model
{
    protected $fillable = [
        'course_id',
        'image',
        'image_alt'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
