<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "user_id",
        "description",
        "active",
        "price",
        "category_id",
        "is_featured",
        "material",
        "printing_type",
        "items_value_discount",
        "items_items_discount",
        "items_items_discount",
    ];

    public function colors()
    {
        return $this->belongsToMany('App\Models\Color', "color_product", "product_id", "color_id");
    }

    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size', "size_product", "product_id", "size_id");
    }

    public function seller()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Product_image');
    }

    public function item_value_discounts()
    {
        return $this->hasMany('App\Models\item_value_discount');
    }

    public function items_value_discounts()
    {
        return $this->hasMany('App\Models\items_value_discount');
    }

    public function items_items_discounts()
    {
        return $this->hasMany('App\Models\items_items_discount');
    }

    public function coupons()
    {
        return $this->hasMany("App\Models\Coupon");
    }

    public function getActiveItemsItemsDiscount()
    {
        $active_discounts_null = $this->items_items_discounts()->where(function ($query) {
            $query->where("starts_at", "<=", date("Y-m-d"))
            ->where("ends_at", null);
        })->get();

        
        $active_discounts = $this->items_items_discounts()->where(function ($query) {
            $query->where("starts_at", "<=", date("Y-m-d"))
            ->where("ends_at", ">=", date("Y-m-d"));
        })->get();

        foreach ($active_discounts_null as $value) {
            $active_discounts->push($value);
        }

        return $active_discounts;
    }

    public function getActiveItemsValueDiscount()
    {
        $active_discounts_null = $this->items_value_discounts()->where(function ($query) {
            $query->where("starts_at", "<=", date("Y-m-d"))
            ->where("ends_at", null);
        })->get();

        
        $active_discounts = $this->items_value_discounts()->where(function ($query) {
            $query->where("starts_at", "<=", date("Y-m-d"))
            ->where("ends_at", ">=", date("Y-m-d"));
        })->get();

        foreach ($active_discounts_null as $value) {
            $active_discounts->push($value);
        }

        return $active_discounts;
    }

    public function getActiveItemValueDiscount()
    {
        $active_discounts_null = $this->item_value_discounts()->where(function ($query) {
            $query->where("starts_at", "<=", date("Y-m-d"))
            ->where("ends_at", null);
        })->get();

        
        $active_discounts = $this->item_value_discounts()->where(function ($query) {
            $query->where("starts_at", "<=", date("Y-m-d"))
            ->where("ends_at", ">=", date("Y-m-d"));
        })->get();

        foreach ($active_discounts_null as $value) {
            $active_discounts->push($value);
        }

        return $active_discounts;
    }

    public function afterDiscountPrice()
    {
        $discount = $this->getActiveItemValueDiscount()->first();

        $value = $discount->value;
        $percent = $discount->percent;

        if ($value && $percent) {
            $price = $this->price - $value;
        } else if ($value && !$percent) {
            $price = $this->price - $value;
        } else {
            $price = $this->price - (($percent / 100) * $this->price);
        }

        return $price;
    }

}
