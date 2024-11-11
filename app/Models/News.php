<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class News extends Model
{
    protected $fillable = [
        'news_category_id',
        'name',
        'slug',
        'thumbnail',
        'thumbnail_alt',
        'image',
        'image_alt',
        'source',
        'source_url',
        'content',
    ];

    public function news_category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function metaDetail(): HasOne
    {
        return $this->hasOne(MetaDetails::class);
    }
}
