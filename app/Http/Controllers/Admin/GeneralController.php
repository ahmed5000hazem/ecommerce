<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function getColors()
    {
        $colors = Color::all();
        return view("admin-views.other.colors", [
            "colors" => $colors
        ]);
    }

    public function storeColor(Request $request)
    {
        $data = $request->only("color", "color_name");
        $request->validate([
            "color" => "required",
            "color_name" => "required",
        ]);
        Color::insert($data);
        return redirect()->back();
    }
    public function deleteColor(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->back();
    }
    
    public function getSizes()
    {
        $sizes = Size::orderBy("size_ordering")->get();
        return view("admin-views.other.sizes", [
            "sizes" => $sizes,
        ]);
    }

    public function storeSize(Request $request)
    {
        $data = $request->only("size", "weight_min", "weight_max", "size_ordering");
        $request->validate([
            "size" => "required",
            "size_ordering" => "required",
        ]);
        Size::insert($data);
        return redirect()->back();
    }
    public function deleteSize(Request $request, $id)
    {
        $color = Size::findOrFail($id);
        $color->delete();
        return redirect()->back();
    }

    public function getReasons()
    {
        $reasons = DB::table('reasons')->get();
        return view("admin-views.other.reasons", [
            "reasons" => $reasons
        ]);
    }
    
    public function storeReason(Request $request)
    {
        $request->validate([
            "reason" => "required",
        ]);
        DB::table('reasons')->insert(["reason" => $request->reason]);
        return redirect()->back();
    }

    public function deleteReason($id)
    {
        $reason = DB::table('reasons')->where("id", $id)->delete();
        return redirect()->back();
    }

}
