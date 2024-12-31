<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    protected $fillable = [
        'blog_category_id',
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

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function metaDetail(): HasOne
    {
        return $this->hasOne(MetaDetails::class);
    }
}
