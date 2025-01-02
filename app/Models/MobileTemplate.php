<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MobileTemplate extends Model
{
    use HasFactory;
    use Searchable;
    
    protected $fillable = [
        'id',
        'Variant SKU',
        'Title',
        'Handle',
        'Brand',
        'gtin',
        'item_model_number',
        'color',
        'ram',
        'storage',
    ];
}