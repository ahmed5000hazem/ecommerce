<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDiscountsRequest;
use App\Models\item_value_discount;
use App\Models\items_value_discount;
use App\Models\items_items_discount;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view("discounts-views.create-discount", [
            "product" => $product,
        ]);
    }

    public function store(StoreDiscountsRequest $request) {

        $product = Product::findOrFail($request->product_id);
        if ($request->item_value_disc_value === null && $request->item_value_disc_percent === null && $request->items_value_disc_value === null && $request->items_value_disc_items_number === null && $request->items_items_disc_buy_items_count === null && $request->items_items_disc_get_items_count === null) {
            // return $request->all();
            return redirect()->back();
        }

        if ($request->item_value_disc_value !== null || $request->item_value_disc_percent !== null) {
            
            $product->item_value_discount = 1;
            $product->save();
            $starts_at = $request->item_value_disc_starts_at;
            if (!$request->item_value_disc_starts_at) 
                $starts_at = now();
            $product->item_value_discounts()->create([
                "value" => $request->item_value_disc_value,
                "percent" => $request->item_value_disc_percent,
                "starts_at" => $starts_at,
                "ends_at" => $request->item_value_disc_ends_at,
            ]);
        }

        if ($request->items_value_disc_value !== null || $request->items_value_disc_items_number !== null) {
            $product->items_value_discount = 1;
            $product->save();
            $starts_at = $request->items_value_disc_starts_at;
            if (!$request->items_value_disc_starts_at)
                $starts_at = now();
            $product->items_value_discounts()->create([
                "items_value" => $request->items_value_disc_value,
                "items_count" => $request->items_value_disc_items_number,
                "starts_at" => $starts_at,
                "ends_at" => $request->items_value_disc_ends_at,
            ]);
        }

        if ($request->items_items_disc_buy_items_count !== null || $request->items_items_disc_get_items_count !== null) {
            $product->items_items_discount = 1;
            $product->save();
            $starts_at = $request->items_items_disc_starts_at;
            if (!$request->items_items_disc_starts_at)
                $starts_at = now();
            $product->items_items_discounts()->create([
                "buy_items_count" => $request->items_items_disc_buy_items_count,
                "get_items_count" => $request->items_items_disc_get_items_count,
                "present_product_id" => $request->items_items_disc_present_product_id,
                "starts_at" => $starts_at,
                "ends_at" => $request->items_items_disc_ends_at,
            ]);
        }

        return redirect()->back();
    }
    public function show($discount_type)
    {
        $all = 0;
        $item_value = 0;
        $items_value = 0;
        $items_items = 0;
        if ($discount_type === "all") {
            $products = Product::where("user_id", auth()->user()->id)
            ->select("id", "name", "price")->get();
            $all= 1;
        } else if ($discount_type === "item-value") {
            $products = Product::where("user_id", auth()->user()->id)
            ->where("item_value_discount", 1)
            ->select("id", "name", "price")->get();
            $item_value = 1;
        } else if ($discount_type === "items-value") {
            $products = Product::where("user_id", auth()->user()->id)
            ->where("items_value_discount", 1)
            ->select("id", "name")->get();
            $items_value = 1;
        } else if ($discount_type === "items-items") {
            $products = Product::where("user_id", auth()->user()->id)
            ->where("items_items_discount", 1)
            ->select("id", "name")->get();
            $items_items = 1;
        } else{
            return redirect()->back();
        }
        // return $products;
        return view("discounts-views.show-discount", [
            "products" => $products,
            "all" => $all,
            "item_value" => $item_value,
            "items_value" => $items_value,
            "items_items" => $items_items,
        ]);

    }
    public function edit($discount_type, $discount_id)
    {
        
        if ($discount_type === "item-value-disc") {
            $discount = item_value_discount::findOrFail($discount_id);
            $product = $discount->product()->first();
            return view("discounts-views.edit-item-value", [
                "discount" => $discount,
                "product" => $product,
            ]);
        } else if ($discount_type === "items-value-disc") {
            $discount = items_value_discount::findOrFail($discount_id);
            $product = $discount->product()->first();
            
            return view("discounts-views.edit-items-value", [
                "discount" => $discount,
                "product" => $product,
            ]);
        } else if ($discount_type === "items-items-disc") {
            $discount = items_items_discount::findOrFail($discount_id);
            $product = $discount->product()->first();
            $present = Product::findOrFail($discount->present_product_id);
            return view("discounts-views.edit-items-items", [
                "discount" => $discount,
                "product" => $product,
                "present" => $present,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update ($discount_type, $discount_id, Request $request){
        if ($discount_type === "item-value-disc") {
            
            $discount = item_value_discount::findOrFail($discount_id);

            $validator = Validator::make($request->all(), [
                "item_value_disc_value" => ["nullable", "numeric"],
                "item_value_disc_percent" => ["nullable", "numeric"],
                "item_value_disc_starts_at" => ["nullable", "date"],
                "item_value_disc_ends_at" => ["nullable", "date"],
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (!$request->item_value_disc_value && !$request->item_value_disc_percent)
            return redirect()->back();
            
            $starts_at = $request->item_value_disc_starts_at;
            if (!$request->item_value_disc_starts_at)
            $starts_at = now();

            $discount->value = $request->item_value_disc_value;
            $discount->percent = $request->item_value_disc_percent;
            $discount->starts_at = $starts_at;
            $discount->ends_at = $request->item_value_disc_ends_at;
            $discount->save();

            return redirect()->back();
        } else if ($discount_type === "items-value-disc") {
            
            $discount = items_value_discount::findOrFail($discount_id);

            $validator = Validator::make($request->all(), [
                "items_value_disc_items_number" => ["required", "numeric"],
                "items_value_disc_value" => ["required", "numeric"],
                "items_value_disc_starts_at" => ["nullable", "date"],
                "items_value_disc_ends_at" => ["nullable", "date"],
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $starts_at = $request->items_value_disc_starts_at;
            if (!$request->items_value_disc_starts_at)
            $starts_at = now();

            $discount->items_count = $request->items_value_disc_items_number;
            $discount->items_value = $request->items_value_disc_value;
            $discount->starts_at = $starts_at;
            $discount->ends_at = $request->items_value_disc_ends_at;
            $discount->save();

            return redirect()->back();
            
        } else if ($discount_type === "items-items-disc") {
            
            $discount = items_items_discount::findOrFail($discount_id);

            $validator = Validator::make($request->all(), [
                "items_items_disc_present_product_id" => ["required", "numeric"],
                "items_items_disc_buy_items_count" => ["required", "numeric"],
                "items_items_disc_get_items_count" => ["required", "numeric"],
                "items_items_disc_starts_at" => ["nullable", "date"],
                "items_items_disc_ends_at" => ["nullable", "date"],
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $starts_at = $request->items_items_disc_starts_at;
            if (!$request->items_items_disc_starts_at)
            $starts_at = now();
            
            $discount->buy_items_count = $request->items_items_disc_buy_items_count;
            $discount->get_items_count = $request->items_items_disc_get_items_count;
            $discount->present_product_id  = $request->items_items_disc_present_product_id;
            $discount->starts_at = $request->items_items_disc_starts_at;
            $discount->ends_at = $request->items_items_disc_ends_at;
            $discount->save();

            return redirect()->back();
        } else {
            return redirect()->back();
        }

    }

    public function delete ($discount_type, $discount_id, Request $request) {
        
        if ($discount_type === "item-value-disc") {

            $discount = item_value_discount::findOrFail($discount_id);
            $product = $discount->product_id;
            $discount->delete();
            $discounts = item_value_discount::where("product_id", $product)->get();
            if ($discounts->isEmpty()){
                Product::where("id", $product)->update(["item_value_discount" => 0]);
            }
            return redirect("/seller/product/".$product);

        } else if ($discount_type === "items-value-disc") {
            
            $discount = items_value_discount::findOrFail($discount_id);
            $product = $discount->product_id;
            $discount->delete();
            $discounts = items_value_discount::where("product_id", $product)->get();
            if ($discounts->isEmpty()){
                Product::where("id", $product)->update(["items_value_discount" => 0]);
            }
            return redirect("/seller/product/".$product);

        } else if ($discount_type === "items-items-disc") {
            $discount = items_items_discount::findOrFail($discount_id);
            $product = $discount->product_id;
            $discount->delete();
            $discounts = items_items_discount::where("product_id", $product)->get();
            if ($discounts->isEmpty()){
                Product::where("id", $product)->update(["items_items_discount" => 0]);
            }
            return redirect("/seller/product/".$product);
        } else {
            return redirect()->back();
        }
    }
}
