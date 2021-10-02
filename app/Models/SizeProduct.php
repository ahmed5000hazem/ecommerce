<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeProduct extends Model
{
    public $table = "size_product";
    protected $fillable = ["product_id", "size_id"];
    public $timestamps = false;
}
