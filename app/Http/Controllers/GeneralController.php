<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GeneralController extends Controller
{
    public function changeLang($lang, Request $request)
    {
        try {
            if (array_key_exists($lang ,config("locale.languages"))) {
                Session::put('locale', $lang);
                App::setLocale($lang);
                return redirect()->back();
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
