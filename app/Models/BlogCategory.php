<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function blog(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function metaDetail(): HasOne
    {
        return $this->hasOne(MetaDetails::class);
    }
}
