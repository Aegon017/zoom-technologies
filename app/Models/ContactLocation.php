<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLocation extends Model
{
    protected $fillable = [
        'location_type',
        'city',
        'address',
        'landline',
        'mobile',
        'email',
        'website',
        'map_iframe',
    ];
}
