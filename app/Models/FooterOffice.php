<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterOffice extends Model
{
    protected $fillable = [
        'footer_section_id',
        'name',
        'location',
        'location_url',
        'mobile',
        'landline',
        'email'
    ];

    protected $casts = [
        'mobile' => 'array',
        'landline' => 'array',
        'email' => 'array'
    ];

    public function footerSection(): BelongsTo
    {
        return $this->belongsTo(FooterSection::class);
    }
}
