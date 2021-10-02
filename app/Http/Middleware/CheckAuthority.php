<?php

namespace App\Http\Middleware;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\item_value_discount;
use App\Models\items_value_discount;
use App\Models\items_items_discount;
use Closure;

class CheckAuthority
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

        if ($request->id !== null) {
            $product = Product::findOrFail($request->id);
            if ($product->user_id === auth()->user()->id) {
                return $next($request);
            } else {
                return redirect()->back();
            }
        } else if ($request->coupon_id !== null) {
            $coupon = Coupon::findOrFail($request->coupon_id);
            if ($coupon->creator_id === auth()->user()->id) {
                return $next($request);
            } else {
                return redirect()->back();
            }
        } else if ($request->product_id !== null) {
            $product = Product::findOrFail($request->product_id);
            if ($product->user_id === auth()->user()->id) {
                return $next($request);
            } else {
                return redirect()->back();
            }
        } elseif ($request->discount_id !== null && $request->discount_type !== null) {
            // return $next($request);
            if ($request->discount_type === "item-value-disc") {
                $discount = item_value_discount::findOrFail($request->discount_id);
                $product =  $discount->product()->first();
                if ($product->user_id === auth()->user()->id) {
                    return $next($request);
                } else {
                    return redirect()->back();
                }
            } else if ($request->discount_type === "items-value-disc") {
                $discount = items_value_discount::findOrFail($request->discount_id);
                $product =  $discount->product()->first();
                if ($product->user_id === auth()->user()->id) {
                    return $next($request);
                } else {
                    return redirect()->back();
                }
            } else if ($request->discount_type === "items-items-disc") {
                $discount = items_items_discount::findOrFail($request->discount_id);
                $product =  $discount->product()->first();
                if ($product->user_id === auth()->user()->id) {
                    return $next($request);
                } else {
                    return redirect()->back();
                }
            } else {
                return redirect()->back();
            }
        } else {
            return $next($request);
        }
    }
}
