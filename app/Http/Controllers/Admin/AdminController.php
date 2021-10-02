<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

use App\Http\Controllers\Controller;
use App\Models\Cart_price;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $countUsers = User::count();

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
        ->select("price", "qty")->get();

        $countProducts = Product::count();

        $date = date("y-m-d h:i:s" , strtotime("-1 week"));

        $lastAddedProducts = Product::where("active", 0)
        ->join("users", "users.id", "=", "products.user_id")
        ->where("products.created_at", ">", $date)
        ->select("name", "products.id", "user_id", "price", "users.fname")
        ->get();

        $lastAddedOrders = Order::where("status", "pending")
        ->join("users", "users.id", "=", "orders.supervisor_id")
        ->where("orders.created_at", ">", $date)
        ->select("orders.total", "orders.id", "orders.created_at", "orders.supervisor_id", "users.fname")
        ->get();

        return view("admin-views.dashboard", [
            "countUsers" => $countUsers,
            "countProducts" => $countProducts,
            "totalQty" => $reports->sum("qty"),
            "totalEarnings" => $reports->sum("price"),
            "lastAddedProducts" => $lastAddedProducts,
            "lastAddedOrders" => $lastAddedOrders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
