<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'created_at',
        'updated_at'
    ];

public function searchPhoneNumber($query, $term)
{
    return $query->where('phone_number', 'LIKE', "%{$term}%");
}

    public function journeys()
    {
        return $this->hasMany(CustomerJourney::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
