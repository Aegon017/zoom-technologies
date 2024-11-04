<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'content',
    ];

    public function news_category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
