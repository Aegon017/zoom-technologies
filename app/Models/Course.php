<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    protected $fillable = [
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
        'sale_price',
        'actual_price',
    ];

    protected $casts = [
        'training_mode' => 'array',
    ];

    public function overview(): HasOne
    {
        return $this->hasOne(Overview::class);
    }

    public function metaDetail(): HasOne
    {
        return $this->hasOne(MetaDetails::class);
    }

    public function curriculum(): HasMany
    {
        return $this->hasMany(Curriculum::class);
    }

    public function subCurriculum(): HasManyThrough
    {
        return $this->hasManyThrough(SubCurriculum::class, Curriculum::class);
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function guideline(): HasMany
    {
        return $this->hasMany(Guideline::class);
    }

    public function studyMaterial(): HasMany
    {
        return $this->hasMany(StudyMaterial::class);
    }

    public function faq(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function manualOrder(): HasMany
    {
        return $this->hasMany(ManualOrder::class);
    }

    public function sampleCertificate(): HasMany
    {
        return $this->hasMany(SampleCertificate::class);
    }
}
