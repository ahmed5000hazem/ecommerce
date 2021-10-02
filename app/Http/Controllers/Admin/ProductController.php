<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Size;
use App\Models\SizeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    private static $mimes = ["jpeg", "jpg", "png", "bmp", "gif", "svg", "webp"];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getQuery(Request $request)
    {
        $query = "";
        if ($request->query("category_id")) {
            $query = "category_id = ".$request->query("category_id");
        }

        if ($request->query("product_type") === "avilable"){
            if ($request->query("category_id")) {
                $query = $query . " AND is_avilable = 1";
            } else {
                $query = $query . " is_avilable = 1";
            }
        } else if ($request->query("product_type") === "not_avilable") {
            if ($request->query("category_id")) {
                $query = $query . " AND is_avilable = 0";
            } else {
                $query = $query . " is_avilable = 0";
            }
        } else if ($request->query("product_type") === "featured") {
            if ($request->query("category_id")) {
                $query = $query. " AND is_featured = 1";
            } else {
                $query = $query . " is_featured = 1";
            }
        } else if ($request->query("product_type") === "not_featured") {
            if ($request->query("category_id")) {
                $query = $query . " AND is_featured = 0";
            } else {
                $query = $query . " is_featured = 0";
            }
        } else if ($request->query("product_type") === "active") {
            if ($request->query("category_id")) {
                $query = $query . " AND active = 1";
            } else {
                $query = $query . " active = 1";
            }
        } else if ($request->query("product_type") === "not_active") {
            if ($request->query("category_id")) {
                $query = $query . " AND active = 0";
            } else {
                $query = $query . " active = 0";
            }
        }
        return $query;
    }
    public function index(Request $request)
    {

        if ($request->query("search")) {
            $search = $request->query("search");
            $products = Product::where("name", "like", "%".$search."%")
            ->orWhere("price", "like", "%".$search."%")
            ->orWhere("id", "like", "%".$search."%")
            ->orWhere("is_featured", "like", "%".$search."%")
            ->get();

            $categories = Category::where("is_parent", 0)->get();

            return view("admin-views.products.products", [
                "products" => $products,
                "categories" => $categories,
            ]);
        }

        if ($request->query("product_type")) {
            $query = $this->getQuery($request);
            $products = Product::whereRaw($query)
            ->join("users", "users.id", "=", "products.user_id")
            ->select("products.*", "users.fname")
            ->orderBy("id", "DESC")
            ->paginate(30);
        } else {
            $products = Product::join("users", "users.id", "=", "products.user_id")
            ->select("products.*", "users.fname")
            ->orderBy("id", "DESC")
            ->paginate(30);
        }

        $categories = Category::where("is_parent", 0)->get();

        return view("admin-views.products.products", [
            "products" => $products,
            "categories" => $categories,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where("is_parent", 0)->get();
        $colors = Color::all();
        $sizes = Size::all();
        return view("admin-views.products.create", [
            "categories" => $categories,
            "colors" => $colors,
            "sizes" => $sizes,
        ]);
    }

    public function getImages(Request $request)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mimes = self::$mimes;
        $validator = Validator::make($request->all(), [
            "name" => ["required", "max:60"],
            "description" => ["required", "max:5000"],
            "price" => ["required"],
            "avilable" => ["required", Rule::in([0,1])],
            "active" => ["required", Rule::in([0,1])],
            "featured" => ["required", Rule::in([0,1])],
            "category" => ["required", "notIn:0"],
            "images"    => ['required', 'array', 'min:1', 'max : 10', "bail"],
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
            $product->active = $request->active;
            $product->is_featured = $request->featured;
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

        

        return redirect("/admin/products");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $product_images = Product_image::where("product_id", "=", $id)->get();
        $sizes = $product->sizes()->get();
        $colors = $product->colors()->get();
        // return $product;
        return view("admin-views.products.product-details", [
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
        // return $product;
        
        $categories = Category::where("is_parent", "0")->select("id", "name")->get();

        $product_sizes = SizeProduct::where("product_id", "=", $id)
        ->join("sizes", "sizes.id", "=", "size_product.size_id")
        ->orderBy("size_ordering")
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

        $sizes = Size::whereNotIn("id", $product_sizes_ids)
        ->orderBy("size_ordering")
        ->select("size", "id")->get();
        $colors = Color::whereNotIn("id", $product_colors_ids)
        ->select("colors.color", "colors.id", "colors.color_name")->get();
        
        

        return view("admin-views.products.edit", [
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
    public function update(Request $request, $id)
    {

        $mimes = self::$mimes;
        $validator = Validator::make($request->all(), [
            "name" => ["required", "max:60"],
            "description" => ["required", "max:5000"],
            "price" => ["required"],
            "avilable" => ["required", Rule::in([0,1])],
            "active" => ["required", Rule::in([0,1])],
            "featured" => ["required", Rule::in([0,1])],
            "category" => ["required", "notIn:0"],
            "images"    => ['required', 'array', 'min:1', 'max : 10', "bail"],
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

        $product = Product::findOrFail($id);
        DB::transaction(function () use ($request, $product) {
            
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->is_avilable = $request->avilable;
            $product->active = $request->active;
            $product->is_featured = $request->featured;
            $product->category_id = $request->category;
            $product->material = $request->material;
            $product->printing_type = $request->printingType;
            $product->save();

            ColorProduct::where("product_id", $product->id)->delete();
            foreach ($request->colors as $color) {
                ColorProduct::create([
                    "product_id" => $product->id, 
                    "color_id" => $color,
                ]);
            }
            
            SizeProduct::where("product_id", $product->id)->delete();
            foreach ($request->sizes as $size) {
                SizeProduct::create([
                    "product_id" => $product->id,
                    "size_id" => $size,
                ]);
            }
            
            Product_image::where("product_id", $product->id)->delete();
            foreach ($request->images as $img) {
                $image = new Product_image;
                $image->product_id = $product->id;
                $image->img = $img;
                $image->path = '/'.auth()->user()->id.'/'.$img;
                $image->save();
            }
        });
        return redirect("/admin/products/");
    }

    public function activate($id)
    {
        Product::where("id", $id)->update([
            "active" => 1,
            "activated_at" => time(),
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)  
    {
        if (!(Hash::check($request->admin_password , auth()->user()->password))) {
            return redirect()->back()->with("error", "Admin password is wrong")->withInput();
        }

        $product = Product::findOrFail($id);
        $product->delete();
        return redirect("/admin/products");
    }
}
