<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ["size", "weight_min", "weight_max", "size_ordering"];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, "size_product");
    }
}
