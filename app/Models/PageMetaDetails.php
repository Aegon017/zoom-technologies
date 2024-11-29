<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageMetaDetails extends Model
{
    protected $fillable = [
        'page_name',
        'title',
        'keywords',
        'description',
    ];
}
