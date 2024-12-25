<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    protected $fillable = [
        'bank_name',
        'ifsc_code',
        'account_name',
        'account_number',
        'branch_name',
        'branch_code',
        'address',
        'notes',
    ];

    protected $casts = [
        'notes' => 'json',
    ];
}
