<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CJProduct extends Model
{
    use HasFactory;

    // Disable timestamps in your model
    public $timestamps = false;

    protected $table = 'cj_products';

    protected $fillable = [
        'customer_journey_id',
        'product_id'
    ];

    public function customerJourney()
    {
        return $this->belongsTo(CustomerJourney::class,'customer_journey_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
