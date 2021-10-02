<?php

namespace App\Http\Middleware;

use Closure;

class InitializeCart
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
        
        if (session("cart") == null) {
            session(["cart" => []]);
            return $next($request);
        }
        return $next($request);
        
    }
}
