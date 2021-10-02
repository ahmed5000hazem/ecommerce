<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    
    public static $presents = [];

    private static function getSessionCartItems () {
        return session("cart");
    }
    private static function setSessionCartItems ($items) {
        session(["cart" => $items]);
    }
    private static function deleteSessionCartItems (array $row_ids) {
        $storedCart = self::getSessionCartItems("cart");
        foreach ($row_ids as $key) {
            unset($storedCart[$key]);
        }
        self::setSessionCartItems($storedCart);
    }
    public static function updateCartItem($oldId, $newId, array $cartItems) {
        $storedCart = self::getSessionCartItems("cart");
        unset($storedCart[$oldId]);
        $storedCart[$newId] = $cartItems;
        self::setSessionCartItems($storedCart);
    }
    public static function addCartItems(array $cartItems)
    {
        $storedCart = self::getSessionCartItems("cart");
        if ($storedCart && $storedCart !== []) {
            $lastCartId = "";
            foreach ($cartItems as $key => $value) {
                if (array_key_exists($key, $storedCart)) {
                    $currentQty = $storedCart[$key]["qty"];
                    if ($currentQty + $value["qty"] <= 12) {
                        $storedCart[$key]["qty"] += $value["qty"];
                    } else {
                        return false;
                    }
                } else {
                    $storedCart[$key] = $value;
                }
                $lastCartId = $key;
            }
            self::setSessionCartItems($storedCart);
            return ["ids" => array_keys($storedCart) , "lastAddedId" => $lastCartId];
        } else {
            self::setSessionCartItems($cartItems);
            return ["ids" => array_keys($cartItems) , "lastAddedId" => key($cartItems)];
        }
    }
    public static function getCartItem($rowId){
        $cartItems = self::getSessionCartItems();
        if (array_key_exists($rowId, $cartItems)) {
            return $cartItems[$rowId];
        }
        return false;
    }
    public static function cartAll()
    {
        return self::getSessionCartItems();
    }
    public static function clearCart() {
        $keys = [];
        $storedCart = self::getSessionCartItems("cart");
        foreach ($storedCart as $key => $value) {
            $keys[] = $key;
        }
        self::deleteSessionCartItems($keys);
    }
    public static function deleteCartItems(array $row_ids) {
        self::deleteSessionCartItems($row_ids);
    }
    public static function decreaseCartQTY ($rowId) {

        $cartItem = self::getCartItem($rowId);
        $cartItem["qty"]--;
        
        self::updateCartItem($rowId, $rowId, $cartItem);
        return $cartItem;
    }
    public static function increaseCartQTY ($rowId) {
        $cartItem =self::getCartItem($rowId);
        $cartItem["qty"]++;
        self::updateCartItem($rowId, $rowId, $cartItem);
        return $cartItem;
    }
    public static function cartTotal ($cartItems) {

        /*

            cartitems is an array of cart items that is an assosiative array contains [
                product_id,
                product_name,
                product_image,
                size,
                color,
                price,
                qty,
            ]
        
        */
        
        $grouped = $cartItems->groupBy("product_id");
        $product_quantities = $grouped->map(function ($item, $key) {
            return [$key => $item->sum("qty")];
        });
        $products_ids = array_keys($product_quantities->all());
        $products = Product::whereIn("id", $products_ids)->select(["price", "name", "id", "item_value_discount", "items_value_discount", "items_items_discount"])->get();
        $products = $products->groupBy("id");
        $item_value_discounts = collect([]);
        $items_value_discounts = collect([]);
        $items_items_discounts = collect([]);
        foreach ($products as $product) {
            if ($product[0]->item_value_discount) {
                $item_value_discounts->put($product[0]->id, $product[0]->getActiveItemValueDiscount());
            }
            if ($product[0]->items_value_discounts) {
                $items_value_discounts->put($product[0]->id, $product[0]->getActiveItemsValueDiscount());
            }
            if ($product[0]->items_items_discounts) {
                $items_items_discounts->put($product[0]->id, $product[0]->getActiveItemsItemsDiscount());
            }
        }
        $product_prices_qty = collect([]);
        $product_present = collect([]);
        foreach ($products_ids as $products_id) {
            $items_value_product_prices_qty = collect([]);
            $product_qty = $product_quantities[$products_id][$products_id];
            $items_items_discounts_product_qty = $product_quantities[$products_id][$products_id];
            if (isset($items_value_discounts[$products_id])) {
                if ($items_value_discounts[$products_id] !== []) {
                    foreach ($items_value_discounts[$products_id] as $discount) {
                        $count = floor($product_qty / $discount->items_count);
                        if ($count) {
                            $items_value_product_prices_qty->push([
                                "product_id" => $products_id,
                                "product_name" => $products[$products_id][0]->name,
                                "qty" => $discount->items_count * $count,
                                "price" => $count*$discount->items_value,
                            ]);
                        }
                    }
                }
            }
            $min_price = $items_value_product_prices_qty->min("price");
            $min_price_disc = [];
            foreach ($items_value_product_prices_qty as $value) {
                if ($value["price"] === $min_price) {
                    $min_price_disc = $value;
                }
            }
            if ($min_price_disc) {
                $product_qty = $product_qty - $min_price_disc["qty"];
                $product_prices_qty->push($min_price_disc);
            }
            if (isset($item_value_discounts[$products_id])) {
                if ($item_value_discounts[$products_id] !== []) {
                    foreach ($item_value_discounts[$products_id] as $discount) {
                        if ($product_qty) {
                            $price = $products[$products_id][0]->price;
                            $value = $discount->value;
                            $percent = $discount->percent;
                            
                            if ($value && $percent) {
                                $price = $price - $value;
                            } else if ($value && !$percent) {
                                $price = $price - $value;
                            } else {
                                $price = $price - (($percent / 100) * $price);
                            }
                            $total = $price*$product_qty;
                            $product_prices_qty->push([
                                "product_id" => $products_id,
                                "product_name" => $products[$products_id][0]->name,
                                "qty" => $product_qty,
                                "price" => $total,
                            ]);
                        }
                    }
                }
            }
            $items_quantity = $product_quantities[$products_id][$products_id];
            if (isset($items_items_discounts[$products_id]) && $items_items_discounts[$products_id] !== []) {
                while ($items_quantity > 0){
                    $max_get_number = 0;
                    $max_buy_number = 0;
                    $offer = [];
                    $max_count = 1;
                    $buy_items_countXcount = 1;
                    foreach ($items_items_discounts[$products_id] as $discount) {
                        $count = floor($items_quantity / $discount->buy_items_count);
                        if ($count) {
                            if ( ($discount->get_items_count * $count) > $max_get_number) {
                                $max_count = $count;
                                $max_get_number = $discount->get_items_count * $count;
                                $buy_items_countXcount = $discount->buy_items_count * $max_count;
                                $offer = [
                                    "product_id" => $products_id,
                                    "buy_items_count" => $discount->buy_items_count,
                                    "default_size" => $grouped[$products_id][0]["size"],
                                    "default_color" => $grouped[$products_id][0]["color"],
                                    "presents_count" => $max_get_number,
                                    "present_product_id" => $discount->present_product_id,
                                ];
                            }
                        }
                    }
                    if (!($offer === [])) 
                    $product_present->push($offer);
                    
                    $items_quantity = $items_quantity - ($buy_items_countXcount);
                }
            }
            if (!$product_prices_qty->contains('product_id', $products_id)){
                $price = $products[$products_id][0]->price;
                $total = $price * $items_items_discounts_product_qty;
                $product_prices_qty->push([
                    "product_id" => $products_id,
                    "qty" => $items_items_discounts_product_qty,
                    "product_name" => $products[$products_id][0]->name,
                    "price" => $total,
                ]);
            }
        }
        session(["presents" => $product_present]);
        $data = ["totals" => $product_prices_qty, "presents" => $product_present];
        return $data;
    }
    public static function getPresents()
    {
        return session("presents");
    }
    public function size()
    {
        return $this->belongsTo("App\Models\Size");
    }
    public function color()
    {
        return $this->belongsTo("App\Models\Color");
    }
    
}
