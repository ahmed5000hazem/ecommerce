<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class items_value_discount extends Model
{
    public $table = "items_value_discounts";
    public $timestamps = false;
    protected $fillable = [
        "product_id",
        "items_value",
        "items_count",
        "starts_at",
        "ends_at",
    ];
    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }
}
