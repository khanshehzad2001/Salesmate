<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;
    
    protected $fillable = [
        'id',
        'title',
        'category_id',
        'product_code',
        'sap_code',
        'price',
        'stock',
        'status',
        'popularity',
        'product_data',
        'url',
        'image_url',
    ];

    public function searchableAs(): string
    {
        return 'prod_smproducts';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customerJourneys()
    {
        return $this->belongsToMany(CustomerJourney::class)->using(CJProduct::class);
    }


    protected function productUrl(): Attribute
    {  
        return Attribute::make(
            get: fn ($value) =>  ($this->product_data) ? config('services.cscart.home_url') . json_decode($this->product_data)->seo_name : config('services.cscart.home_url'),
        );
    }

    public function mobileTemplate()
    {
        return $this->hasOne(MobileTemplate::class);
    }
}