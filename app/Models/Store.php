<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    
    public function uriKey()
    {
        return $this->id;
    }

    protected $fillable = [
        'code',
        'title',
        'address',
        'geo_code',
    ];

    /**
     * Get the users associated with the store.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}