<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureCard extends Model
{
    protected $fillable = [
        'feature_section_id',
        'icon',
        'number',
        'title',
        'content'
    ];

    public function featureSection(): BelongsTo
    {
        return $this->belongsTo(FeatureSection::class);
    }
}
