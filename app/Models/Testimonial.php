<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $fillable = [
        'testimonial_section_id',
        'content',
        'name',
        'location',
    ];

    public function testimonialSection(): BelongsTo
    {
        return $this->belongsTo(TestimonialSection::class);
    }
}
