<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "user_id",
        "coupon",
        "subtotal",
        "shipping",
        "total",
        "status",
        "phone",
        "status",
        "address_one",
        "address_two",
        "governorate",
    ];

    public function canceledOrders()
    {
        return $this->hasMany("App\Models\CanceledOrders");
    }
    
    public function rejectedOrders()
    {
        return $this->hasMany("App\Models\RejectedOrders");
    }

    public function orderPrices()
    {
        return $this->hasMany("App\Models\Cart_price");
    }

    public function presents()
    {
        return $this->hasMany("App\Models\Present");
    }

    public function cart()
    {
        return $this->hasMany("App\Models\Cart");
    }

    public function supervisor()
    {
        return $this->belongsTo("App\Models\User", "supervisor_id", "id");
    }
    
    public function owner()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

}
