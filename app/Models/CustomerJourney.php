<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class CustomerJourney extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone_number',
        'email',
        'outcome_id',
        'reason',
        'remark',
        'user_id',
        'store_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function outcome()
    {
        return $this->belongsTo(Option::class, 'outcome_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cj_products', 'customer_journey_id', 'product_id');
    }
}