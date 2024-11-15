<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterSection extends Model
{
    protected $fillable = [
        'logo',
        'logo_alt',
        'content',
        'social_links'
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function footerOffice(): HasMany
    {
        return $this->hasMany(FooterOffice::class);
    }
}
