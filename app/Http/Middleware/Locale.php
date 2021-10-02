<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // if (config("locale.status") && array_key_exists(Session::get("locale"), config("locale.languages"))) {
        //     App::setLocale(Session::get("locale"));
        // } else {
        //     $userLanguages = preg_split('/[,;]/', $request->server("HTTP_ACCEPT_LANGUAGE"));

        //     foreach ($userLanguages as $lang) {
        //         if (array_key_exists($lang, config("locale.languages"))) {
                    App::setLocale("ar");
                    setlocale(LC_TIME, config("locale.languages")["ar"][2]);
                    Carbon::setLocale(config('locale.languages')["ar"][0]);
                    if (config("locale.languages")["ar"][2]) {
                        \session(['lang-rtl' => true]);
                    } else {
                        Session::forget('lang-rtl');
                    }
        //             break;
        //         }
        //     }

        // }

        return $next($request);
    }
}
