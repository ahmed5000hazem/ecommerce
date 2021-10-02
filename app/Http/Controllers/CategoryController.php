<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getSellerProduct($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where([
            ["category_id", $id],
            ["user_id", auth()->user()->id],
        ])->paginate(30);
        return view("category-views.category-products", [
            "products" => $products,
            "category" => $category
        ]);
    }
}
