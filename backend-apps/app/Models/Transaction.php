<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'branch_store_id',
        'transaction_date',
        'total_amount',
        'status_payment',
        'status_laundry',
        'urlPaymentGateway',
        'notes'
    ];
    
}
