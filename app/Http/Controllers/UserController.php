<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
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

     public function index()
    {
        return view("shop.user.account", [
            "categories" => self::$groupedCategories,
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

    public function editPassword()
    {
        return view("shop.user.edit-password", [
            "categories" => self::$groupedCategories,
        ]);
    }
    
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "old_password" => ["required"],
            "password" => ["required", "min:6", "confirmed"],
            "password_confirmation" => ["required", "min:6"],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if (!(Hash::check($request->old_password , auth()->user()->password))) {
            return redirect()->back()->with("error_password_wrong", "password is wrong")->withInput();
        }
        
        $user = User::find(auth()->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect("/account")->with("password_success_message", "password changed successfully");
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
            "governorate" => [
                "nullable",
                Rule::in(['cairo', 'giza']),
            ],
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

        return redirect()->back();
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
