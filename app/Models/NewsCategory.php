<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NewsCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function metaDetail(): HasOne
    {
        return $this->hasOne(MetaDetails::class);
    }
}
