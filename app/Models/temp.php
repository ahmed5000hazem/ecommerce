<?php
function cartTotal ($cartItems) {

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

        // $item_value_discounts = item_value_discount::where(function ($query) {
        //     $query->whereDate("starts_at", "<=", date("Y-m-d"))
        //     ->whereDate("ends_at", ">=", date("Y-m-d"));
        // })->orWhere(function ($query) {
        //     $query->whereDate("starts_at", "<=", date("Y-m-d"))
        //     ->whereNull("ends_at");
        // })->get();
    }
    if ($product[0]->items_value_discounts) {
        $items_value_discounts->put($product[0]->id, $product[0]->getActiveItemsValueDiscount());
        // $items_value_discounts = items_value_discount::where(function ($query) {
        //     $query->whereDate("starts_at", "<=", date("Y-m-d"))
        //     ->whereDate("ends_at", ">=", date("Y-m-d"));
        // })->orWhere(function ($query) {
        //     $query->whereDate("starts_at", "<=", date("Y-m-d"))
        //     ->whereNull("ends_at");
        // })->get();
    }
    if ($product[0]->items_items_discounts) {
        $items_items_discounts->put($product[0]->id, $product[0]->getActiveItemsItemsDiscount());
        // $items_items_discounts = items_items_discount::where(function ($query) {
        //     $query->whereDate("starts_at", "<=", date("Y-m-d"))
        //     ->whereDate("ends_at", ">=", date("Y-m-d"));
        // })->orWhere(function ($query) {
        //     $query->whereDate("starts_at", "<=", date("Y-m-d"))
        //     ->whereNull("ends_at");
        // })->get();
    }
}
// return $item_value_discounts;
// return $items_value_discounts;
// return $items_items_discounts;

// if ($item_value_discounts)
// $item_value_discounts = $item_value_discounts->groupBy("product_id");
// if ($items_value_discounts)
// $items_value_discounts = $items_value_discounts->groupBy("product_id");
// if ($items_items_discounts)
// $items_items_discounts = $items_items_discounts->groupBy("product_id");
// return $item_value_discounts;

// return $items_value_discounts;
// return $items_items_discounts;
$product_prices_qty = collect([]);
$product_present = collect([]);
foreach ($products_ids as $products_id) {
    $product_qty = $product_quantities[$products_id][$products_id];
    $items_items_discounts_product_qty = $product_quantities[$products_id][$products_id];
    if (isset($items_value_discounts[$products_id])) {
        if ($items_value_discounts[$products_id] !== []) {
            foreach ($items_value_discounts[$products_id] as $discount) {
                $count = floor($product_qty / $discount->items_count);
                if ($count) {
                    $product_prices_qty->push([
                        "product_id" => $products_id,
                        "product_name" => $products[$products_id][0]->name,
                        "qty" => $discount->items_count * $count,
                        "price" => $count*$discount->items_value,
                    ]);
                    $product_qty = $product_qty - ($count * $discount->items_count);
                }
            }
        }
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
    if (isset($items_items_discounts[$products_id])) {
        if ($items_items_discounts[$products_id] !== []) {
            $items_number = $items_items_discounts_product_qty;
            $max_get_number = 0;
            // $product_present = collect([]);
            foreach ($items_items_discounts[$products_id] as $discount) {
                $count = floor($items_number / $discount->buy_items_count);
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
                if ($count) {
                    if ($discount->get_items_count > $max_get_number) {
                        $max_get_number = $discount->get_items_count * $count;
                        
                        $offer = [
                            "product_id" => $products_id,
                            "buy_items_count" => $discount->buy_items_count,
                            "presents_count" => $max_get_number,
                            "present_product_id" => $discount->present_product_id,
                        ];
                    }
                }
            }
            $product_present->push($offer);
        }
    }
}
$data = ["totals" => $product_prices_qty, "presents" => $product_present];
return $data;
}