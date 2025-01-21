<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseCoordinator extends Model
{
    protected $fillable = [
        'course_id',
        'coordinator_name',
        'signature_image',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
