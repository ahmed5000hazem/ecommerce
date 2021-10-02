<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class items_items_discount extends Model
{
    public $table = "items_items_discounts";
    public $timestamps = false;
    protected $fillable = [
        "product_id",
        "present_product_id",
        "buy_items_count",
        "get_items_count",
        "starts_at",
        "ends_at",
    ];
    
    public function present() {
        return $this->hasOne("App\Models\Product", "id", "present_product_id");
    }

    public function product()
    {
        return $this->belongsTo("App\Models\Product");
    }
}
