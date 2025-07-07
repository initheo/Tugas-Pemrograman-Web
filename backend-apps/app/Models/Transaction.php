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
        'voucher_id',
        'transaction_date',
        'base_amount',
        'discount_amount',
        'total_amount',
        'status_payment',
        'status_laundry',
        'urlPaymentGateway',
        'payment_session_id',
        'payment_reference_id',
        'notes',
        'payment_method'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branchStore()
    {
        return $this->belongsTo(BranchStore::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
