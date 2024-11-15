<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestimonialSection extends Model
{
    protected $fillable = [
        'title',
        'heading',
        'image'
    ];

    public function testimonial(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }
}
