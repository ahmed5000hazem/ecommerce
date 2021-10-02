<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    use GeneralTrait;


    private static $groupedCategories;
    private static $categories;
    private static $sizes;
    // private static $cart;

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



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public static function generateRowId($cartItem) {
        return $cartItem["product_id"]."-".$cartItem["size"]."-".$cartItem["color"];
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return $this->handelSuccessRedirect([
                "status" => false,
                "not_auth" => true,
                "msg" => ["somthing went wrong"],
                "loaction" => route("login")
            ]);
        }

        $product = Product::findOrFail($request->product_id);
        $productImage = Product_image::where("product_id", $request->product_id)->select("path")->first();

        $validator = Validator::make($request->all(), [
            "product_id" => ["required"],
            "size" => ["required", "numeric", "exists:sizes,id"],
            "color" => ["required", "numeric", "exists:colors,id"],
            "qty" => ["required", "min:1", "max:12"],
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
            return $this->handelErrorRedirect($request, [
                "status" => false,
                "errors" => $errors->all()
            ]);
        }
        
        $cartItem = [
            $product->id."-".$request->size."-".$request->color => [
                "product_id" => $product->id,
                "product_name" => $product->name,
                "product_image" => $productImage,
                "size" => $request->size,
                "color" => $request->color,
                "price" => $product->price,
                "qty" => $request->qty,
            ]
        ];
        $newCart = Cart::addCartItems($cartItem);
        $cartItems = Cart::cartAll();
        if ($newCart) {
            return $this->handelSuccessRedirect([
                "status" => true,
                "msg" => ["product added successfully"],
                "ids" => $cartItems,
                "cartCount" => count($cartItems),
            ]);
        } else {
            return $this->handelSuccessRedirect([
                "status" => false,
                "msg" => ["somthing went wrong"],
                "ids" => $cartItems,
                "cartCount" => count($cartItems),
            ]);
        }
    }

    public function increaseCartItem($cartRowId)
    {
        $cartItem = Cart::getCartItem($cartRowId);
        $cartItemQty = $cartItem["qty"];
        if ($cartItem) {
            if (++$cartItemQty <= 12) {
                Cart::increaseCartQTY($cartRowId);
                return $this->handelSuccessRedirect([
                    "status" => true,
                    "msg" => ["product qantity increased successfully"],
                    "newQty" => $cartItemQty,
                ]);
            } else {
                return $this->handelSuccessRedirect([
                    "status" => false,
                    "msg" => ["product qantity can't be more than 12"],
                ]);
            }
        } else {
            return $this->handelSuccessRedirect([
                "status" => false,
                "msg" => ["cart row id is not valid"],
            ]);
        }
    }
    public function decreaseCartItem($cartRowId)
    {
        $cartItem = Cart::getCartItem($cartRowId);
        $cartItemQty = $cartItem["qty"];
        if ($cartItem) {
            if (--$cartItemQty) {
                Cart::decreaseCartQTY($cartRowId);
                return $this->handelSuccessRedirect([
                    "status" => true,
                    "msg" => ["product qantity decreased successfully"],
                    "newQty" => --$cartItem["qty"],
                ]);
            } else {
                return $this->handelSuccessRedirect([
                    "status" => false,
                    "msg" => ["product qantity can't be less than 1"],
                ]);
            }
        } else {
            return $this->handelSuccessRedirect([
                "status" => false,
                "msg" => ["cart row id is not valid"],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
        // Cart::clearCart();

        // return Cart::cartAll();

        $cartItems = collect(Cart::cartAll());


        return view("shop.cart", [
            "cartItems" => $cartItems,
            "categories" => self::$groupedCategories,
            "cartPage" => true,
        ]);
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
        $cart = Cart::getCartItem($id);
        if ($cart) {
            Cart::deleteCartItems([$id]);
            $cartAll = Cart::cartAll();
            return $this->handelSuccessRedirect([
                "status" => true,
                "ids" => $cartAll,
                "cartCount" => count($cartAll),
            ]);
        } else {
            $cartAll = Cart::cartAll();
            return $this->handelErrorRedirect([
                "status" => false,
                "ids" => $cartAll,
                "cartCount" => count($cartAll),
            ]);
        }
    }
}
