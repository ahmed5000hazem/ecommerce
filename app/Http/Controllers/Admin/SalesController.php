<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart_price;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $reports = Cart_price::whereRaw("EXISTS (
            SELECT
                id
            FROM
                orders
            WHERE
                orders.id = cart_prices.order_id
            AND
                orders.status IN ('fullfied')
        )")
        ->join("orders", "orders.id", "=", "cart_prices.order_id")
        ->select("cart_prices.*", "orders.status", "orders.created_at")->orderBy("order_id", "DESC")->paginate(50);

        return view("admin-views.orders.sales", [
            "reports" => $reports,
        ]);
    }
}
