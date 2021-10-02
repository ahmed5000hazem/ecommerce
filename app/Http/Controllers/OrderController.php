<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_price;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Present;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    private static $groupedCategories;
    private static $categories;

    function __construct()
    {
        
        if (!self::$categories) {
            $categories = Category::all();
            self::$categories = $categories;
        } else {
            $categories = self::$categories;
        }
        $grouped = $categories->groupBy('is_parent');
        self::$groupedCategories = $grouped;

    }

    public function getUserOrders()
    {
        $user = auth()->user();
        $orders = $user->orders()->orderBy("id", "DESC")->get();

        return view("shop.user.orders", [
            "orders" => $orders,
            "categories" => self::$groupedCategories,
        ]);
    }

    public function getUserOrderDetails ($id) {
        $order = Order::findOrFail($id);
        if ($order->user_id !== auth()->user()->id) {
            return redirect()->back();
        }

        $cart = Cart::where("order_id", $id)
        ->join("products", "carts.product_id", "=", "products.id")
        ->select("carts.*","products.name")
        ->get();

        $reasons = DB::table('reasons')->get();

        $cart_prices = DB::table('cart_prices')->where("order_id", $id)->get();

        $canceled_orders = DB::table('canceled_orders')->where("order_id", $id)->get();
        
        $returned_orders = DB::table('returned_orders')->where("order_id", $id)->get();
        
        if ($canceled_orders->isNotEmpty()) $canceled = 1; else $canceled = 0;
        if ($returned_orders->isNotEmpty()) $rejected = 1; else $rejected = 0;

        $presents = Present::where("order_id", $id)
        ->join("products", "products.id" , "=", "presentes.product_id")
        ->select("presentes.*", "products.name")
        ->get();

        return view("shop.user.order-details", [
            "order" => $order,
            "cart" => $cart,
            "cart_prices" => $cart_prices,
            "canceled" => $canceled,
            "rejected" => $rejected,
            "reasons" => $reasons,
            "presents" => $presents,
            "categories" => self::$groupedCategories,
        ]);

    }

    public function getSupervisorOrderDetails ($id) {
        $order = Order::findOrFail($id);
        if ($order->supervisor_id !== auth()->user()->id) {
            return redirect()->back();
        }

        $cart = Cart::where("order_id", $id)
        ->join("products", "carts.product_id", "=", "products.id")
        ->select("carts.*","products.name")
        ->get();

        $reasons = DB::table('reasons')->get();

        $cart_prices = DB::table('cart_prices')->where("order_id", $id)->get();
        
        $canceled_orders = DB::table('canceled_orders')->where("order_id", $id)->get();
        
        $returned_orders = DB::table('returned_orders')->where("order_id", $id)->get();
        
        if ($canceled_orders->isNotEmpty()) $canceled = 1; else $canceled = 0;
        if ($returned_orders->isNotEmpty()) $rejected = 1; else $rejected = 0;

        $presents = Present::where("order_id", $id)
        ->join("products", "products.id" , "=", "presentes.product_id")
        ->select("presentes.*", "products.name")
        ->get();

        return view("supervisor.order-details", [
            "order" => $order,
            "cart" => $cart,
            "cart_prices" => $cart_prices,
            "canceled" => $canceled,
            "rejected" => $rejected,
            "reasons" => $reasons,
            "presents" => $presents,
            "categories" => self::$groupedCategories,
        ]);

    }

    public function getSellerOrders ()
    {
        $seller_id = auth()->user()->id;

        $orders = Order::whereRaw("EXISTS (
            SELECT
                id
            FROM
                carts
            WHERE
                carts.order_id = orders.id
            AND
                EXISTS (
                    SELECT 
                        id 
                    FROM
                        products
                    WHERE
                        user_id = ?
                )
        )", ["user_id" => $seller_id])
        ->whereIn("status", ["process", "pending", "canceled"])
        ->orderBy("created_at", "DESC")
        ->select("id", "status", "created_at")
        ->paginate(30);

        return view("seller-views.orders", [
            "orders" => $orders,
        ]);

    }

    public function getSellerCanceledOrders ()
    {
        $seller_id = auth()->user()->id;

        $orders = Order::whereRaw("EXISTS (
            SELECT
                id
            FROM
                carts
            WHERE
                carts.order_id = orders.id
            AND
                EXISTS (
                    SELECT 
                        id 
                    FROM
                        products
                    WHERE
                        user_id = ?
                )
        )", ["user_id" => $seller_id])
        ->where("status", "canceled")
        ->orderBy("created_at", "DESC")
        ->select("id", "status", "created_at")
        ->paginate(30);

        return view("seller-views.orders", [
            "orders" => $orders,
        ]);
    }

    public function getSellerRejectedOrders ()
    {
        $seller_id = auth()->user()->id;

        $orders = Order::whereRaw("EXISTS (
            SELECT
                id
            FROM
                carts
            WHERE
                carts.order_id = orders.id
            AND
                EXISTS (
                    SELECT 
                        id 
                    FROM
                        products
                    WHERE
                        user_id = ?
                )
        )", ["user_id" => $seller_id])
        ->where("status", "rejected")
        ->orderBy("created_at", "DESC")
        ->select("id", "status", "created_at")
        ->paginate(30);

        return view("seller-views.orders", [
            "orders" => $orders,
        ]);
    }

    public function getSellerOrderDetails($id)
    {
        $seller_id = auth()->user()->id;
        $cart_products = Cart::where("order_id", $id)
        ->join("products", "products.id", "=", "carts.product_id")
        ->select("Products.user_id")->get();
        $cart_products = $cart_products->map(function ($item) {
            return $item->user_id;
        });
        if (!in_array($seller_id, $cart_products->toArray())) {
            return redirect()->back();
        }

        $order = Order::find($id);

        $cart = Cart::whereRaw("EXISTS (
            SELECT 
                id 
            FROM
                products
            WHERE
                carts.product_id = products.id
            AND
                user_id = ?
        )", ["user_id" => $seller_id])
        ->where("order_id", $id)
        ->join("products", "products.id", "=", "carts.product_id")
        ->select("carts.*", "products.name")
        ->get();

        $cart_prices = Cart_price::whereRaw("EXISTS (
            SELECT 
                id 
            FROM
                products
            WHERE
                cart_prices.product_id = products.id
            AND
                user_id = ?
        )", ["user_id" => $seller_id])
        ->where("order_id", $id)
        ->join("products", "products.id", "=", "cart_prices.product_id")
        ->select("cart_prices.*", "products.name")
        ->get();

        $presents = Present::whereRaw("EXISTS (
            SELECT 
                id 
            FROM
                products
            WHERE
                presentes.product_id = products.id
            AND
                user_id = ?
        )", ["user_id" => $seller_id])
        ->where("order_id", $id)
        ->join("products", "products.id", "=", "presentes.product_id")
        ->get();
        
        // return $presents;

        return view("seller-views.order-details", [
            "cart" => $cart,
            "order" => $order,
            "cart_prices" => $cart_prices,
            "presents" => $presents,
        ]);

    }

    public function rejectOrder($id)
    {
        $order = Order::findOrFail($id);

        if ( $order->supervisor_id !== auth()->user()->id ) {
            return redirect()->back();
        }

        $returned_orders = DB::table('returned_orders')->where("order_id", $id)->get();
        if ($returned_orders->isEmpty()) {
            return redirect()->back();
        }

        $order->status = "rejected";
        $order->save();

        return redirect()->back();
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        if ( $order->supervisor_id !== auth()->user()->id ) {
            return redirect()->back();
        }

        $returned_orders = DB::table('canceled_orders')->where("order_id", $id)->get();
        if ($returned_orders->isEmpty()) {
            return redirect()->back();
        }

        $order->status = "canceled";
        $order->save();

        return redirect()->back();
    }

    public function changeOrderStatus($id, Request $request)
    {
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

        if ( $order->supervisor_id !== auth()->user()->id ) {
            return redirect()->back();
        }

        $order->status = $request->order_status;
        $order->save();
        
        return redirect()->back();
    }

    public function cancelOrderRequest($id, Request $request)
    {
        
        // return $request->all();

        $validator = Validator::make($request->all(), [
            "reasons" => "array",
        ]);
        
        if ($validator->fails()) {
            redirect()->back();
        }

        $order = Order::findOrFail($id);

        if ( $order->user_id !== auth()->user()->id ) {
            return redirect()->back();
        }

        $canceled_orders = DB::table('canceled_orders')->where("order_id", $id)->get();
        if ($canceled_orders->isNotEmpty()) {
            return redirect()->back();
        }

        if ($request->reasons) {
            $canceled = [];
            foreach ($request->reasons as $value) {
                $reason = [];
                $reason["reason_id"] = $value;
                $reason["order_id"] = $id;
                $canceled[] = $reason;
            }
        } else {
            $canceled = ["order_id" => $id];
        }

        DB::table('canceled_orders')->insert($canceled);

        return redirect()->back()->with("success", "success to cancel order");

    }
    
    public function rejectOrderRequest($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            "reasons" => "array",
        ]);

        if ($validator->fails()) {
            redirect()->back();
        }

        $order = Order::findOrFail($id);

        if ( $order->user_id !== auth()->user()->id ) {
            return redirect()->back();
        }

        $returned_orders = DB::table('returned_orders')->where("order_id", $id)->get();
        if ($returned_orders->isNotEmpty()) {
            return redirect()->back();
        }

        if ($request->reasons) {
            $rejected = [];
            foreach ($request->reasons as $value) {
                $reason = [];
                $reason["reason_id"] = $value;
                $reason["order_id"] = $id;
                $rejected[] = $reason;
            }
        } else {
            $rejected = ["order_id" => $id];
        }

        DB::table('returned_orders')->insert($rejected);

        return redirect()->back()->with("success", "Return request has been sent");
    }

    public function placeOrder(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            "fname" => "required|string",
            "lname" => "required|string",
            "address_one" => "required|string",
            "address_two" => "nullable|string",
            "phone" => [
                "required",
                "string",
                "starts_with:011,012,010,015",
                Rule::unique('users', "phone")->ignore(auth()->user()->id),
            ],
            "email" => "nullable|email",
            "coupon" => "nullable|exists:coupons,coupon",
            "governorate" => [
                "nullable",
                Rule::in(['cairo', 'giza']),
            ],
            "presents_sizes" => "nullable",
            "presents_colors" => "nullable",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user = User::find(auth()->user()->id);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address_one = $request->address_one;
        $user->address_two = $request->address_two;
        $user->city = $request->governorate;
        $user->save();
        
        
        if ($request->coupon) {
            $coupon = Coupon::where("coupon", $request->coupon)->first();
            // $coupon = Coupon::where("coupon", "ahmed")->first();
            // return var_dump($coupon);
            if (!$coupon){
                return redirect()->back()->with("errors", "coupon does not exist")->withInput();
            }
            if($coupon->user_id != null && $coupon->user_id !== auth()->user()->id){
                return redirect()->back()->with("errors", "You are not allowed to use this coupon")->withInput();
            }

            if (!$coupon->isActive()) {
                return redirect()->back()->with("errors", "this coupon is expired")->withInput();
            }
            if ($coupon->howmany_uses){
                if ($coupon->howManyUsed() >= $coupon->howmany_uses) {
                    return redirect()->back()->with("errors", "this coupon is expired")->withInput();
                }
            }
        }
        
        $cart = collect(Cart::cartAll());
        if ($cart->isEmpty()) {
            redirect()->back();
        }
        $cartItems = [];
        foreach ($cart as $value) {
            $cartItems[] = $value;
        }
        $cartItems = collect($cartItems);
        // return cart::$presents;

        $cart_calculated = Cart::cartTotal($cartItems);
        
        $totals = collect($cart_calculated["totals"]);
        $presents = collect($cart_calculated["presents"]);

        $subTotal = $totals->sum("price");
        $shipping = 45;

        if ($request->coupon) {
            if ($coupon->min_order_price > $subTotal) {
                return redirect()->back()->with("errors", "this coupon will be avillable when buy at price ".$coupon->min_order_price)->withInput();
            }
            $totalPrice = ($subTotal + $shipping) - $coupon->value;
        } else {
            $totalPrice = ($subTotal + $shipping);
        }

        if ($totalPrice < 0) {
            $totalPrice = 0;
        }
        if ($request->coupon) {
            if ($coupon->howmany_uses){
                $coupon->incrementUsedTimes();
            }
        }

        DB::transaction(function () use ($presents, $request, $subTotal, $shipping, $totalPrice, $totals) {
            
            $role = Role::where("name", "supervisor")->select("id")->first();
            
            $supervisors = DB::table('role_user')->where("role_id", $role->id)
            ->join("users", "users.id", "=", "role_user.user_id")->select("id")->get();
    
            $supervisors = $supervisors->map(function ($item) {
                return $item->id;
            });
            $supervisors = $supervisors->toArray();
            $supervisor = Arr::random($supervisors);
            
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->coupon = $request->coupon;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->total = $totalPrice;
            $order->status = "pending";
            $order->phone = $request->phone;
            $order->address_one = $request->address_one;
            $order->address_two = $request->address_two;
            $order->governorate = $request->governorate;
            $order->supervisor_id = $supervisor;
            $order->order_number = "ORD-".Str::random(13).rand(100, 999);
            $order->save();

            $cart_prices = [];
            foreach ($totals as $value) {
                $newValue = [];
                $newValue["product_id"] = $value["product_id"];
                $newValue["product_name"] = $value["product_name"];
                $newValue["price"] = $value["price"];
                $newValue["qty"] = $value["qty"];
                $newValue["order_id"] = $order->id;
                $cart_prices[] = $newValue;
            }
            DB::table("cart_prices")->insert($cart_prices);

            $raw_cart_products = Cart::cartAll();
            
            $cart_products = [];
            foreach ($raw_cart_products as $value) {
                $newValue = [];
                $newValue["product_id"] = $value["product_id"];
                $newValue["color_id"] = $value["color"];
                $newValue["size_id"] = $value["size"];
                $newValue["qty"] = $value["qty"];
                $newValue["order_id"] = $order->id;
                $cart_products[] = $newValue;
            }
            Cart::insert($cart_products);

            $presents_array = [];
            if (!$request->presents_sizes && !$request->presents_colors) {
                foreach ($presents as $value) {
                    $newPresent = [];
                    $newPresent["product_id"] = $value["present_product_id"];
                    $newPresent["color_id"] = $value["default_color"];
                    $newPresent["size_id"] = $value["default_size"];
                    $newPresent["order_id"] = $order->id;
                    $newPresent["presents_count"] = $value["presents_count"];
                    $presents_array[] = $newPresent;
                }
            } else {
                foreach ($presents as $value) {
                    $newPresent = [];
                    $newPresent["product_id"] = $value["present_product_id"];
                    $newPresent["color_id"] = $request->presents_colors[$value["present_product_id"]];
                    $newPresent["size_id"] = $request->presents_sizes[$value["present_product_id"]];
                    $newPresent["order_id"] = $order->id;
                    $newPresent["presents_count"] = $value["presents_count"];
                    $presents_array[] = $newPresent;
                }
            }
            Present::insert($presents_array); 
        });
        
        Cart::clearCart();

        return view("shop.place-order", [
            "categories" => self::$groupedCategories,
        ]);
    }
}