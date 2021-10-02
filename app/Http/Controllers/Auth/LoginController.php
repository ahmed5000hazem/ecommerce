<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

// use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    public function login(){
        return view("auth.login");
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only(["password", "phone"]);

        $validator = Validator::make($credentials, [
            "phone" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($credentials, true)) {
            return redirect()->back();
        } else {
            Session::flash('logErrors', "Phone number or password are wrong");
            return redirect()->back();
        }

    }

    // public function redirectToFacebook ()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function handlefacebookCallback () {
    //     $user = Socialite::driver('facebook')->user();
    // }
}
