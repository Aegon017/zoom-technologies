<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetaDetails extends Model
{
    protected $fillable = [
        'course_id',
        'package_id',
        'news_category_id',
        'news_id',
        'title',
        'keywords',
        'description'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function newsCategory(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
