<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if (auth()->user()->hasRole("admin")) {
                return redirect("/admin");
            } elseif (auth()->user()->hasRole("seller")) {
                return redirect("/seller");
            } elseif (auth()->user()->hasRole("supervisor")) {
                return redirect("/supervisor");
            } else {
                return redirect("/");
            }
        
        }

        return $next($request);
    }
}
