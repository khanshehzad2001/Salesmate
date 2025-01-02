<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscovery extends Model
{
    use HasFactory;
    protected $fillable = [
      
        'store_id',
        'title',
        'image_url',
        'script',
    ];

    public function store(){
        return $this->belongsTo (Store::class,'store_id');
    }
}