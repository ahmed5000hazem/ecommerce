<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item_value_discount extends Model
{
    public $table = "item_value_discounts";
    protected $fillable = [
        "product_id",
        "value",
        "percent",
        "starts_at",
        "ends_at",
    ];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }
}
