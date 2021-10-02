<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where("creator_id", auth()->user()->id)->get();
        return view("admin-views.coupons.coupons", [
            "coupons" => $coupons
        ]);
    }

    public function create()
    {
        return view("admin-views.coupons.create-coupon");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "coupon" => ["required", "unique:coupons,coupon"],
            "coupon_value" => ["required", "numeric"],
            "coupon_product_id" => ["nullable", "exists:products,id"],
            "coupon_howmany_uses" => ["nullable", "numeric"],
            "coupon_min_order_price" => ["nullable", "numeric"],
            "coupon_starts_at" => ["nullable", "date"],
            "coupon_ends_at" => ["nullable", "date"],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $starts_at = $request->coupon_starts_at;
        if(!$request->coupon_starts_at)
        $starts_at = now();

        $coupon = new Coupon;
        $coupon->coupon = $request->coupon;
        $coupon->value = $request->coupon_value;
        $coupon->product_id = $request->product_id;
        $coupon->creator_id = auth()->user()->id;
        $coupon->howmany_uses = $request->coupon_howmany_uses;
        $coupon->min_order_price = $request->coupon_min_order_price;
        $coupon->starts_at = $starts_at;
        $coupon->ends_at = $request->coupon_ends_at;
        $coupon->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view("admin-views.coupons.edit-coupon", [
            "coupon" => $coupon,
        ]);
    }

    public function update(Request $request, $coupon_id)
    {

        $coupon = Coupon::findOrFail($coupon_id);
        $validator = Validator::make($request->all(), [
            "coupon" => ["required", Rule::unique('coupons')->ignore($coupon_id)],
            "coupon_value" => ["required", "numeric"],
            "coupon_product_id" => ["nullable", "exists:products,id"],
            "coupon_howmany_uses" => ["nullable", "numeric"],
            "coupon_min_order_price" => ["nullable", "numeric"],
            "coupon_starts_at" => ["nullable", "date"],
            "coupon_ends_at" => ["nullable", "date"],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $starts_at = $request->coupon_starts_at;
        if(!$request->coupon_starts_at)
        $starts_at = now();

        $coupon->coupon = $request->coupon;
        $coupon->value = $request->coupon_value;
        $coupon->product_id = $request->product_id;
        $coupon->creator_id = auth()->user()->id;
        $coupon->howmany_uses = $request->coupon_howmany_uses;
        $coupon->min_order_price = $request->coupon_min_order_price;
        $coupon->starts_at = $starts_at;
        $coupon->ends_at = $request->coupon_ends_at;
        $coupon->save();

        return redirect()->back();
    }

    public function destroy($coupon_id)
    {
        $coupon = Coupon::findOrFail($coupon_id);
        $coupon->delete();
        return redirect("/admin/coupons/");
    }

    

}
