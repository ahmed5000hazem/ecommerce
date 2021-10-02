<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function getCategories(Request $request, $type = "all")
    {
        if ($type === "all") {
            $categories = Category::all();
        } else if ($type === "main") {
            $categories = Category::where("is_parent", 1)->get();
        } else if ($type === "sub") {
            $categories = Category::where("is_parent", 0)
            ->leftJoin("products", "products.category_id", "=", "categories.id")
            ->selectRaw("categories.*, count(products.id) as product_count")
            ->groupBy("categories.id")
            ->get();
        } else {
            return redirect()->back();
        }

        return view("admin-views.categories.categories", [
            "categories" => $categories,
        ]);
    }

    public function categoryDetails($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::where("is_parent", 1)->get();
        return view("admin-views.categories.category-details", [
            "category" => $category,
            "parents" => $parents,
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::where("is_parent", 1)->get();
        return view("admin-views.categories.create", [
            "parents" => $parents,
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
        $request->validate([
            "name" => "required",
            "is_parent" => Rule::in([0, 1]),
            "parent_id" => Rule::requiredIf(!($request->is_parent)),
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->is_parent = $request->is_parent;
        if (!$request->is_parent && $request->parent_id) {
            $category->parent_id = $request->parent_id;
        } else {
            $category->parent_id = null;
        }
        $category->save();

        return redirect()->back();
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
        // return $request->is_parent;
        
        $request->validate([
            "name" => "required",
            "is_parent" => Rule::in([0, 1]),
            "parent_id" => Rule::requiredIf(!($request->is_parent)),
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->is_parent = $request->is_parent;
        if (!$request->is_parent && $request->parent_id) {
            $category->parent_id = $request->parent_id;
        } else {
            $category->parent_id = null;
        }
        $category->save();

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

        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect("/admin/categories");
    }
}
