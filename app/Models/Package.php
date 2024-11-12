<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Package extends Model
{
    protected $fillable = [
        'courses',
        'name',
        'slug',
        'thumbnail',
        'thumbnail_alt',
        'image',
        'image_alt',
        'outline_pdf',
        'video_link',
        'short_description',
        'duration',
        'duration_type',
        'training_mode',
        'placement',
        'certificate',
        'original_price',
        'price',
    ];

    protected $casts = [
        'training_mode' => 'array',
        'courses' => 'array'
    ];

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function overview(): HasOne
    {
        return $this->hasOne(Overview::class);
    }

    public function metaDetail(): HasOne
    {
        return $this->hasOne(MetaDetails::class);
    }

    public function guideline(): HasMany
    {
        return $this->hasMany(Guideline::class);
    }

    public function faq(): HasMany
    {
        return $this->hasMany(Faq::class);
    }
}
