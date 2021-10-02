<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Present;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    public function getQuery(Request $request)
    {
        $query = "";
        if ($request->query("order_type")) {
            $query = "status = '".$request->query("order_type")."'";
        }
        
        return $query;
    }

    public function index(Request $request)
    {

        if ($request->query("search")){
            $orders = Order::whereRaw("
                id = ?
                OR
                phone = ?
                OR
                subtotal = ?
                OR
                shipping = ?
                OR EXISTS(
                    SELECT
                        id
                    FROM
                        users
                    WHERE
                        users.id = orders.user_id
                    AND
                        fname = ?
                )
            ", [
                "id" => $request->query("search"),
                "phone" => $request->query("search"),
                "subtotal" => $request->query("search"),
                "shipping" => $request->query("search"),
                "fname" => $request->query("search"),
            ])
            ->orWhere("address_one", "like", "%" . $request->query("search"). "%")
            ->orWhere("address_two", "like", "%" . $request->query("search"). "%")
            ->orWhere("total", "like", $request->query("search"). "%")
            ->orderBy("id", "DESC")->get();
            return view("admin-views.orders.orders", [
                "orders" => $orders,
            ]);
        }

        if ($request->query("order_type")) {
            $query = $this->getQuery($request);
            $orders = Order::whereRaw($query)->orderBy("id", "DESC")->paginate(30);
        } else {
            $orders = Order::orderBy("id", "DESC")->paginate(30);
        }

        return view("admin-views.orders.orders", [
            "orders" => $orders,
        ]);
    }

    public function cancelRequsets (Request $request)
    {
        if ($request->query("order_type")) {
            $query = $this->getQuery($request);
            $orders = Order::whereRaw($query)
            ->whereRaw("EXISTS (
                SELECT 
                    id
                FROM
                    canceled_orders
                Where
                    canceled_orders.order_id = orders.id
                AND 
                    orders.status 
                IN ('pending', 'process')
            )")
            ->orderBy("id", "DESC")->paginate(30);
        } else {
            $orders = Order::whereRaw("EXISTS (
                SELECT 
                    id
                FROM
                    canceled_orders
                Where
                    canceled_orders.order_id = orders.id
                AND 
                    orders.status 
                IN ('pending', 'process')
            )")->orderBy("id", "DESC")->paginate(30);
        }

        return view("admin-views.orders.orders", [
            "orders" => $orders,
        ]);
    }

    public function rejectRequsets (Request $request)
    {
        if ($request->query("order_type")) {
            $query = $this->getQuery($request);
            $orders = Order::whereRaw($query)
            ->whereRaw("EXISTS (
                SELECT 
                    id
                FROM
                    returned_orders
                Where
                    returned_orders.order_id = orders.id
                AND 
                    orders.status 
                IN ('fullfied')
            )")
            ->orderBy("id", "DESC")->paginate(30);
        } else {
            $orders = Order::whereRaw("EXISTS (
                SELECT 
                    id
                FROM
                    returned_orders
                Where
                    returned_orders.order_id = orders.id
                AND 
                    orders.status 
                IN ('fullfied')
            )")->orderBy("id", "DESC")->paginate(30);
        }

        return view("admin-views.orders.orders", [
            "orders" => $orders,
        ]);
    }
    
    public function getOrderDetails($id)
    {
        $order = Order::findOrFail($id);

        $cart = Cart::where("order_id", $id)
        ->join("products", "carts.product_id", "=", "products.id")
        ->select("carts.*","products.name")
        ->get();

        $cart_prices = DB::table('cart_prices')->where("order_id", $id)->get();
        
        $canceled_orders = DB::table('canceled_orders')
        ->where("order_id", $id)
        ->join("reasons", "canceled_orders.reason_id", "=", "reasons.id")
        ->get();
        
        $returned_orders = DB::table('returned_orders')
        ->where("order_id", $id)
        ->join("reasons", "returned_orders.reason_id", "=", "reasons.id")
        ->get();
        
        if ($canceled_orders->isNotEmpty()) $canceled = 1; else $canceled = 0;
        if ($returned_orders->isNotEmpty()) $rejected = 1; else $rejected = 0;

        $presents = Present::where("order_id", $id)
        ->join("products", "products.id" , "=", "presentes.product_id")
        ->select("presentes.*", "products.name")
        ->get();

        return view("admin-views.orders.order-details", [
            "order" => $order,
            "cart" => $cart,
            "cart_prices" => $cart_prices,
            "canceled" => $canceled,
            "canceled_orders" => $canceled_orders,
            "rejected" => $rejected,
            "returned_orders" => $returned_orders,
            "presents" => $presents,
        ]);
    }

    public function changeOrderStatus($id, Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            "order_status" => [
                "required", 
                Rule::in([
                    'pending', 
                    'process',
                    'shipped',
                    'fullfied',
                    'canceled',
                    'rejected',
                ]),
            ],
        ]);
        
        if ($validator->fails()) {
            redirect()->back();
        }

        $order = Order::findOrFail($id);

        $order->status = $request->order_status;
        $order->save();
        
        return redirect()->back();
    }
}
