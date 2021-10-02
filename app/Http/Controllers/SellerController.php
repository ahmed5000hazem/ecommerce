<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

class SellerController extends Controller
{
    public function index()
    {
        $seller_id = auth()->user()->id;
        $sold_products = DB::table('cart_prices')->whereRaw("EXISTS (
            SELECT 
                id 
            FROM 
                products 
            WHERE 
                cart_prices.product_id = products.id 
            AND 
                user_id = " . $seller_id . " 
        )")
        ->whereRaw("EXISTS(
            SELECT 
                id 
            FROM 
                orders 
            WHERE 
                cart_prices.order_id = orders.id 
            AND 
                status = 'fullfied' 
        )")
        ->select("price")->get();

        $date = date("y-m-d h:i:s" , time() + (( 2-6 ) * 3600));

        $ordered_products = Cart::whereRaw("EXISTS(
            SELECT 
                id 
            FROM 
                products 
            WHERE 
                carts.product_id = products.id 
            AND 
                user_id = " . $seller_id . " 
        )")->whereRaw("
            EXISTS(
                SELECT 
                    id 
                FROM 
                    orders 
                WHERE 
                    carts.order_id = orders.id 
                AND 
                    status IN ('pending', 'process', 'canceled')
        )")
        ->where("carts.created_at", ">=", $date)
        ->join("sizes", "sizes.id", "=", "carts.size_id")
        ->join("colors", "colors.id", "=", "carts.color_id")
        ->join("orders", "orders.id", "=", "carts.order_id")
        ->join("products", "products.id", "=", "carts.product_id")
        ->select("carts.*", "products.name", "colors.color_name", "colors.color", "sizes.size", "orders.status")
        ->orderBy("order_id")
        ->get();

        return view("seller-views.dashboard", [
            "sold_products" => $sold_products,
            "ordered_products" => $ordered_products,
        ]);
    }
}
