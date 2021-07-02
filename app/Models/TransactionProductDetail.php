<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'transaction_id', 'qty', 'price', 'subtotal'
    ];
}
