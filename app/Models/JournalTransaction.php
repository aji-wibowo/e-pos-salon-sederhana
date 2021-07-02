<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'transaction_id', 'account_id', 'notes'
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'account_id');
    }
}
