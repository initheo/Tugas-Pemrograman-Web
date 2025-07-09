<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'address',
        'city',
        'postal_code'
    ];

    /**
     * Get the user that owns the customer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the customer.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }

}
