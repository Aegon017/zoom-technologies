<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timezone extends Model
{
    protected $fillable = [
        'timezone_name',
        'offset',
        'abbreviation'
    ];

    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
