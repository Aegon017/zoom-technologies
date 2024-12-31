<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetaDetails extends Model
{
    protected $fillable = [
        'course_id',
        'package_id',
        'blog_category_id',
        'blog_id',
        'title',
        'keywords',
        'description',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
