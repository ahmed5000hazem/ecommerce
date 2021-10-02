<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class RegisterController extends Controller
{
    public function register()
    {
        return view("Auth.register");
    }
    public function signup(Request $request)
    {
        $data = $request->only(["phone", "password", "password_confirmation"]);

        $validator = Validator::make($data, [
            "phone" => ["required", "size:11", "unique:users,phone"],
            "password" => ["required", "confirmed"]
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $user = new User;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->save();

            $normal_user = Role::where("name", "=", "normal_user")->first();

            $user->attachRole($normal_user);
        });

        Auth::attempt($data, true);
        return redirect()->route("root");

    }
}
