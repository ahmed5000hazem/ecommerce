<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorProduct extends Model
{
    public $table = "color_product";
    protected $fillable = ["product_id", "color_id"];
    public $timestamps = false;
}
