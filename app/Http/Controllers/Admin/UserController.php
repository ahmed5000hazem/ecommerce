<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getUsers(Request $request, $role = "normal_user")
    {

        if ($role === "normal_user") {
            $normalUserRole = Role::where("name", "normal_user")->first();
        } else if ($role === "seller") {
            $normalUserRole = Role::where("name", "seller")->first();
        } else if ($role === "supervisor") {
            $normalUserRole = Role::where("name", "supervisor")->first();
        } else {
            return redirect()->back();
        }
        
        if ($request->query("search")){
            $users = User::orderBy("id")
            ->whereRaw("EXISTS (
                select 
                    user_id
                FROM
                    role_user
                where
                    role_user.user_id = users.id
                AND
                    role_id = ?
            )", ["role_id" => $normalUserRole->id])
            ->where(function ($query) use ($request) {
                $query->where("fname", "like", "%". $request->query("search") . "%")
                ->orWhere("lname", "like", "%". $request->query("search") . "%")
                ->orWhere("phone", "like", "%". $request->query("search") . "%")
                ->orWhere("email", "like", "%". $request->query("search") . "%");
            })
            ->get();
        }else {
            $users = $normalUserRole->users()->orderBy("id")->paginate(30);
        }

        return view("admin-views.users.normal-users" , [
            "users" => $users,
        ]);

    }

    public function userDetails($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view("admin-views.users.user-details", [
            "roles" => $roles,
            "user" => $user,
        ]);
    }

    public function createUser()
    {
        $roles = Role::all();
        
        return view("admin-views.users.create-user", ["roles" => $roles]);
    }

    public function storeUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "fname" => "nullable|string",
            "lname" => "nullable|string",
            "password" => "required|confirmed|string|min:6",
            "address_one" => "nullable|string",
            "address_two" => "nullable|string",
            "phone" => [
                "required",
                "string",
                "starts_with:011,012,010,015",
                Rule::unique('users', "phone"),
                // Rule::unique('users', "phone")->ignore(auth()->user()->id),
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

        $user = new User;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->address_one = $request->address_one;
        $user->address_two = $request->address_two;
        $user->city = $request->governorate;
        $user->save();
        
        

        if(!($request->role_id)){
            $role_id = Role::where("name", "normal_user")->select("id")->first();
            $role_id = $role_id->id;
        } else {
            $role_id = $request->role_id;
            $role = Role::where("id", $role_id)->select("name")->first();
            if ($role->name === "seller") {
                Storage::disk('product-images')->makeDirectory("/sellers/".$user->id, 0775, true);
            }
        }

        DB::table('role_user')->insert([
            "role_id" => $role_id,
            "user_id" => $user->id,
        ]);

        return redirect()->back()->with("success", "success to create user");

    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "fname" => "nullable|string",
            "lname" => "nullable|string",
            "address_one" => "nullable|string",
            "address_two" => "nullable|string",
            "phone" => [
                "required",
                "string",
                "starts_with:011,012,010,015",
                Rule::unique('users', "phone")->ignore($user->id),
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

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address_one = $request->address_one;
        $user->address_two = $request->address_two;
        $user->city = $request->governorate;
        $user->save();

        DB::table('role_user')->where("user_id", $user->id)->delete();
        $role = Role::where("id", $request->role_id)->select("name")->first();
        if ($role->name === "seller") {
            Storage::disk('product-images')->makeDirectory("/sellers/".$user->id, 0775, true);
        }
        
        DB::table('role_user')->insert([
            "role_id" => $request->role_id,
            "user_id" => $user->id,
        ]);

        return redirect()->back()->with("success", "success to create user");

    }

    public function editPassword($id)
    {
        $user = User::findOrFail($id);
        return view("admin-views.users.edit-password", ["user" => $user]);
    }

    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "admin_password" => ["required"],
            "password" => ["required", "min:6", "confirmed"],
            "password_confirmation" => ["required", "min:6"],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if (!(Hash::check($request->admin_password , auth()->user()->password))) {
            return redirect()->back()->with("error", "Admin password is wrong")->withInput();
        }
        
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect("/admin/user/".$id."/show")->with("success", "password changed successfully");
    }

    public function deleteUser(Request $request, $id)
    {

        if (!(Hash::check($request->admin_password , auth()->user()->password))) {
            return redirect()->back()->with("error", "Admin password is wrong")->withInput();
        }
        $user = User::findOrFail($id);
        Storage::disk('product-images')->deleteDirectory("/sellers/".$user->id);
        $user->delete();
        return redirect("/admin/users");
    }
    
}
