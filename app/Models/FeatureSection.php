<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeatureSection extends Model
{
    protected $fillable = [
        'title',
        'heading',
        'content',
    ];

    public function featureCard(): HasMany
    {
        return $this->hasMany(FeatureCard::class);
    }
}
