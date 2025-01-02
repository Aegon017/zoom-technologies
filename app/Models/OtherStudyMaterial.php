<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherStudyMaterial extends Model
{
    protected $fillable = [
        'name',
        'image',
        'image_alt',
        'material_url',
        'material_pdf',
        'subscription',
    ];
}
