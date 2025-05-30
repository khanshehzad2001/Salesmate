<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'title'
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
