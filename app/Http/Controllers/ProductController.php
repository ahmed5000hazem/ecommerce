<?php

namespace App\Http\Controllers;

use App\Models\Cart_price;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product_image;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\ColorProduct;
use App\Models\SizeProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    private static $mimes = ["jpeg", "jpg", "png", "bmp", "gif", "svg", "webp"];



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSellerProducts()
    {

        $products = Product::where("user_id", auth()->user()->id)
        ->join("categories", "products.category_id", "=", "categories.id")
        ->select("products.*", "categories.name as category_name")
        ->paginate(30);

        return view("product-views.products", [
            "products" => $products
        ]);
    }
    public function getAdminProducts()
    {
        
    }
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where("is_parent", "0")->select("id", "name")->get();
        $colors = Color::all();
        $size = Size::orderBy("size_ordering")->get();
        return view("product-views.product-add", [
            "categories" => $categories,
            "colors" => $colors,
            "sizes" => $size,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mimes = self::$mimes;
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "name" => ["required", "max:60"],
            "description" => ["required", "max:5000"],
            "price" => ["required"],
            "avilable" => ["required", Rule::in([0, 1])],
            "category" => ["required", "notIn:0"],
            "images"    => ['required', 'array', 'min:2', 'max : 10', "bail"],
            "sizes"    => ['required', 'array', 'min:1', "bail"],
            "colors"    => ['required', 'array', 'min:1', "bail"],
            "images.*" => ['distinct'],
            function ($value, $fail) use ($mimes) {
                $imgs = $value;
                foreach ($imgs as $img) {
                    $explode = explode(".", $img);
                    $explode = $explode[count($explode) - 1];
                    if (!(in_array($explode , $mimes))) {
                        $fail('Not Images.');
                    }
                }
            }
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::transaction(function () use ($request) {
            $product = new Product;
            $product->name = $request->name;
            $product->user_id = auth()->user()->id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->is_avilable = $request->avilable;
            $product->category_id = $request->category;
            $product->material = $request->material;
            $product->printing_type = $request->printingType;
            $product->save();

            foreach ($request->colors as $color) {
                ColorProduct::create([
                    "product_id" => $product->id, 
                    "color_id" => $color,
                ]);
            }
            foreach ($request->sizes as $size) {
                SizeProduct::create([
                    "product_id" => $product->id,
                    "size_id" => $size,
                ]);
            }

            foreach ($request->images as $img) {
                $image = new Product_image;
                $image->product_id = $product->id;
                $image->img = $img;
                $image->path = '/'.auth()->user()->id.'/'.$img;
                $image->save();
            }
            
        });
        return redirect("/seller/products");
    }

    public function getSellerImages()
    {
        $id = auth()->user()->id;
        $path = "/sellers/". $id . "/";
        $fullPath = "/products/sellers/". $id . "/";
        $images = Storage::disk("product-images")->allFiles($path);
        return response()->json([
            "disk" => "images",
            "path" => $fullPath,
            "images" => $images,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $product_images = Product_image::where("product_id", "=", $id)->get();
        $sizes = SizeProduct::where("product_id", "=", $id)
        ->join("sizes", "sizes.id", "=", "size_product.size_id")
        ->select("sizes.*")
        ->get();
        $colors = ColorProduct::where("product_id", "=", $id)
        ->join("colors", "colors.id", "=", "color_product.color_id")
        ->select("colors.*")->get();
        return view("product-views.product-show", [
            "product" => $product,
            "product_images" => $product_images,
            "sizes" => $sizes,
            "colors" => $colors,
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
        $product = Product::where("products.id", $id)
        ->join("categories", "categories.id", "=", "products.category_id")
        ->select("products.*", "categories.name as category_name")
        ->first();
        
        $categories = Category::where("is_parent", "0")->select("id", "name")->get();

        $product_sizes = SizeProduct::where("product_id", "=", $id)
        ->join("sizes", "sizes.id", "=", "size_product.size_id")
        ->select("sizes.size", "sizes.id")
        ->get();
        $product_colors = ColorProduct::where("product_id", "=", $id)
        ->join("colors", "colors.id", "=", "color_product.color_id")
        ->select("colors.color", "colors.id", "colors.color_name")->get();

        $product_sizes_ids = $product_sizes->map(function ($item) {
            return $item->id;
        });

        $product_colors_ids = $product_colors->map(function ($item) {
            return $item->id;
        });

        $sizes = Size::whereNotIn("id", $product_sizes_ids)->select("size", "id")->get();
        $colors = Color::whereNotIn("id", $product_colors_ids)->select("colors.color", "colors.id", "colors.color_name")->get();
        
        return view("product-views.product-edit", [
            "product" => $product,
            "categories" => $categories,
            "product_sizes" => $product_sizes,
            "product_colors" => $product_colors,
            "colors" => $colors,
            "sizes" => $sizes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mimes = self::$mimes;
        
        $validator = Validator::make($request->all(), [
            "name" => ["required", "max:60"],
            "description" => ["required", "max:5000"],
            "price" => ["required"],
            "avilable" => ["required", Rule::in([0,1])],
            "category" => ["required", "notIn:0"],
            "images"    => ['required', 'array', 'min:2', 'max : 7', "bail"],
            "sizes"    => ['required', 'array', 'min:1', "bail"],
            "colors"    => ['required', 'array', 'min:1', "bail"],
            "images.*" => ['distinct'],
            function ($value, $fail) use ($mimes) {
                $imgs = $value;
                foreach ($imgs as $img) {
                    $explode = explode(".", $img);
                    $explode = $explode[count($explode) - 1];
                    if (!(in_array($explode , $mimes))) {
                        $fail('Not Images.');
                    }
                }
            }
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->product_id);
        DB::transaction(function () use ($request, $product) {
            
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->is_avilable = $request->avilable;
            $product->category_id = $request->category;
            $product->material = $request->material;
            $product->printing_type = $request->printingType;
            $product->save();

            ColorProduct::where("product_id", $request->product_id)->delete();
            foreach ($request->colors as $color) {
                ColorProduct::create([
                    "product_id" => $product->id, 
                    "color_id" => $color,
                ]);
            }
            
            SizeProduct::where("product_id", $request->product_id)->delete();
            foreach ($request->sizes as $size) {
                SizeProduct::create([
                    "product_id" => $product->id,
                    "size_id" => $size,
                ]);
            }
            
            Product_image::where("product_id", $request->product_id)->delete();
            foreach ($request->images as $img) {
                $image = new Product_image;
                $image->product_id = $product->id;
                $image->img = $img;
                $image->path = '/'.auth()->user()->id.'/'.$img;
                $image->save();
            }
        });
        return redirect("/seller/products/");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            "product" => "required|numeric|min:1",
        ]);

        $product = Product::findOrFail($request->product);
        $product->delete();

        return redirect()->route("sellerProdcut");
    }

    public function sales()
    {
        $seller_id = auth()->user()->id;

        $cart_prices = Cart_price::whereRaw("EXISTS (
            SELECT
                id
            FROM
                products
            WHERE
                cart_prices.product_id = products.id
            AND
                products.user_id = ?
        )", ["user_id" => $seller_id])
        ->join("products", "cart_prices.product_id", "=", "products.id")
        ->select("cart_prices.*", "products.created_at")
        ->orderBy("created_at", "DESC")
        ->get();

        $cart_prices_grouped = $cart_prices->groupBy("product_id");

        return view("seller-views.sales", [
            "cart_prices" => $cart_prices,
            "products" => $cart_prices_grouped,
        ]);

    }

}
