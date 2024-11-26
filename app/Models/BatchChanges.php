<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchChanges extends Model
{
    protected $filllable = [
        'user_id',
        'ip_address',
        'proof'
    ];
}
