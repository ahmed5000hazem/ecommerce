<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ["color", "color_name"];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
