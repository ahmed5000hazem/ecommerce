<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    protected $table = "product_images";
    protected $fillable = ["product_id", "img", "path"];
}
