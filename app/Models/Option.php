<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'title',
        'group_id'
    ];

    public function optionGroup()
    {
        return $this->belongsTo(OptionGroup::class,'group_id');
    }
}
