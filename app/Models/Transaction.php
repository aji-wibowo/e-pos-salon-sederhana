<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'total', 'customer_id', 'cashier_id'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo('App\Models\User', 'cashier_id');
    }

    public function jurnal()
    {
        return $this->hasOne('App\Models\JournalTransaction', 'transaction_id');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\TransactionProductDetail', 'transaction_id');
    }
}
