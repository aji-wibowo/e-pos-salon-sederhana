<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'account_code', 'name', 'type_of_account', 'account_status', 'normal_saldo'
    ];
}
