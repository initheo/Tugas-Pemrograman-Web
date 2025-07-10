<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'service_code',
        'duration'
    ];

    // Append is_active to JSON serialization
    protected $appends = ['is_active'];

    // Accessor untuk is_active (untuk kompatibilitas dengan frontend)
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    // Mutator untuk is_active
    public function setIsActiveAttribute($value)
    {
        $this->status = $value ? 'active' : 'inactive';
    }
    
}
