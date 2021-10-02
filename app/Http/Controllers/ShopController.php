<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\ColorProduct;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Size;
use App\Models\SizeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{

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
        
        if (!self::$sizes) {
            $sizes = Size::orderBy("size_ordering", "ASC")->get();
            self::$sizes = Size::orderBy("size_ordering", "ASC")->get();
        } else {
            $sizes = self::$sizes;
        }
        
    }

    public function index ()
    {
        
        $categories = self::$groupedCategories;

        $featured = Product::where("is_featured", 1)
        ->where("active", 1)
        ->where("is_avilable", 1)
        ->get();

        return view("shop.index", [
            "categories" => $categories,
            "featuredProducts" => $featured,
        ]);
    }

    public function category($id, Request $request)
    {
        // return $request->query();

        $category = Category::findOrFail($id);
        if ($request->query()) {
            $validator = Validator::make($request->query(),[
                'min_price' => ["numeric", "nullable"],
                'max_price' => ["numeric", "nullable"],
                'size' => ["numeric", "nullable"],
                'sort_by' => [
                    "nullable",
                    function ($attribute, $value, $fail) use ($request) {
                        $sort_keys = ["ASC", "DESC", "asc", "desc"];
                        $sort_cols = ["created_at", "price"];
                        $exploded = explode("-", $request->query("sort_by"));
                        if (count($exploded) != 2) {
                            $fail($attribute.' is invalid.');
                        } else {
                            if (!in_array($exploded[0], $sort_cols)) {
                                $fail($attribute.' is invalid.');
                            }
                            if (!in_array($exploded[1], $sort_keys)) {
                                $fail($attribute.' is invalid.');
                            }
                        }
                    }
                ],
            ]);

            if ($validator->fails()){
                return redirect()->back();
            }

        }

        $products = Product::where("category_id", $id)
        ->where("active", 1)
        ->where("is_avilable", 1);

        if ($request->query("min_price")) {
            $products->where("price", ">=", $request->query("min_price"));
        }

        if ($request->query("max_price")) {
            $products->where("price", "<=", $request->query("max_price"));
        }
        
        if ($request->query("size")){
            $products->whereRaw("EXISTS(
                SELECT
                    id
                FROM
                    size_product
                WHERE
                    size_product.product_id = products.id
                AND
                    size_id = ?
            )", [
                "size_id" => $request->query("size")
            ]);
        }

        if ($request->query("sort_by")) {
            $exploded = explode("-", $request->query("sort_by"));
            $products->orderBy($exploded[0], $exploded[1]);
        }

        $products = $products->paginate(30);

        $max_price = Product::where("category_id", $id)->where("active", 1)->where("is_avilable", 1)->max('price');
        $min_price = Product::where("category_id", $id)->where("active", 1)->where("is_avilable", 1)->min('price');

        return view("shop.category", [
            "products" => $products,
            "category" => $category,
            "categories" => self::$groupedCategories,
            "sizes" => self::$sizes,
            "max_price" => $max_price,
            "min_price" => $min_price,
        ]);

    }

    public function categories($id)
    {
        
    }

    public function checkout()
    {
        $cart = collect(Cart::cartAll());
        $cartItems = [];
        foreach ($cart as $value) {
            $cartItems[] = $value;
        }
        $cartItems = collect($cartItems);

        $cart_calculated = Cart::cartTotal($cartItems);
        
        $totals = collect($cart_calculated["totals"]);
        $presents = collect($cart_calculated["presents"]);

        return view("shop.checkout", [
            "totals" => $totals,
            "presents" => $presents,
            "categories" => self::$groupedCategories,
        ]);
    }

    public function getPresents()
    {
        $presents = Cart::getPresents();
        $presents_by_id = $presents->groupBy("present_product_id");

        $ids = array_keys($presents_by_id->all());

        $presents_products = Product::whereIn("id", $ids)->select("id", "name")->get();
        $presents_products = $presents_products->groupBy("id");

        $sizes = SizeProduct::whereIn("product_id", $ids)
        ->join("sizes", "size_product.size_id", "=", "sizes.id")
        ->get();
        $sizes = $sizes->groupBy("product_id");
        
        $colors = ColorProduct::whereIn("product_id", $ids)
        ->join("colors", "color_product.color_id", "=", "colors.id")
        ->get();
        $colors = $colors->groupBy("product_Id");

        $images = Product_image::whereIn("product_id", $ids)->select("product_id", "path")->get();
        $images = $images->groupBy("product_id");

        return response()->json([
            "status" => true,
            "data" => [
                "sizes" => $sizes,
                "colors" => $colors,
                "ids" => $ids,
                "images" => $images,
                "presents" => $presents,
                "presents_products" => $presents_products,
            ],
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->active || !$product->is_avilable){
            return redirect()->back();
        }

        $category = $product->category()->first();

        $featured = $category->getFeaturedProducts()->get();

        return view("shop.product-details", [
            "product" => $product,
            "categories" => self::$groupedCategories,
            "category" => $category,
            "featuredProducts" => $featured,
        ]);
    }

    public function search(Request $request)
    {
        // return $request->all();
        if ($request->query()) {
            $validator = Validator::make($request->query(),[
                'min_price_lg' => ["numeric", "nullable"],
                'max_price_lg' => ["numeric", "nullable"],
                "s" => ["required", "string"],
                'sort_by' => [
                    "nullable",
                    function ($attribute, $value, $fail) use ($request) {
                        $sort_keys = ["ASC", "DESC", "asc", "desc"];
                        $sort_cols = ["created_at", "price"];
                        $exploded = explode("-", $request->query("sort_by"));
                        if (count($exploded) != 2) {
                            $fail($attribute.' is invalid.');
                        } else {
                            if (!in_array($exploded[0], $sort_cols)) {
                                $fail($attribute.' is invalid.');
                            }
                            if (!in_array($exploded[1], $sort_keys)) {
                                $fail($attribute.' is invalid.');
                            }
                        }
                    }
                ],
            ]);

            if ($validator->fails()){
                return redirect()->back();
            }

        }
        $s = $request->query("s");

        $products = Product::where("active", 1)->where("is_avilable", 1)
        ->where(function ($query) use ($s) {
            $query->where("name", "like", "%".$s."%")
            ->orWhere("price", "like", $s."%")
            ->orWhere("material", "like", $s."%")
            ->orWhereRaw("EXISTS (
                SELECT 
                    id
                FROM 
                    size_product
                WHERE 
                    size_product.product_id = products.id
                AND
                    EXISTS (
                        SELECT 
                            id
                        FROM
                            sizes
                        WHERE
                            sizes.id = size_product.size_id
                        AND
                            size = ?
                    )
            )", [
                "size" => $s
            ]);
        });
        

        if ($request->query("sort_by")) {
            $exploded = explode("-", $request->query("sort_by"));
            $products->orderBy($exploded[0], $exploded[1]);
        }

        if ($request->query("min_price")) {
            $products->where("price", ">=", $request->query("min_price"));
        }

        if ($request->query("max_price")) {
            $products->where("price", "<=", $request->query("max_price"));
        }

        $max_price = $products->max("price");
        $min_price = $products->min("price");

        return view("shop.search", [
            "products" => $products->get(),
            "categories" => self::$groupedCategories,
            "max_price" => $max_price,
            "min_price" => $min_price,
        ]);

    }

}
