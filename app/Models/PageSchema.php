<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSchema extends Model
{
    protected $fillable = [
        'local_schema',
        'organization_schema',
        'page_name',
    ];
}
