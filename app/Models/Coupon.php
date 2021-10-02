<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupon extends Model
{
    public $timestamps = false;

    public function isActive()
    {
        $starting = date("Y-m-d", strtotime($this->starts_at));
        $now = date("Y-m-d", time());
        if ($this->ends_at == null) {
            if ($starting <=  $now){
                return true;
            }
        } else {
            $ending = date("Y-m-d", strtotime($this->ends_at));
            if ($starting <=  $now && $ending >= $now){
                return true;
            }
        }
        return false;
    }

    public function howManyUsed()
    {
        $howManyUsed = DB::table('coupon_uses')->where("coupon_id", $this->id)->where("user_id", auth()->user()->id)->first();
        if ($howManyUsed) {
            return $howManyUsed->howmany_used;
        }
        return 0;
    }
    public function incrementUsedTimes()
    {
        $howManyUsed = DB::table('coupon_uses')->where("coupon_id", $this->id)->where("user_id", auth()->user()->id)->first();
        if ($howManyUsed) {
            DB::table('coupon_uses')->where("coupon_id", $this->id)->where("user_id", auth()->user()->id)->increment('howmany_used');
        } else {
            DB::table('coupon_uses')->insert([
                "coupon_id" => $this->id,
                "user_id" => auth()->user()->id,
            ]);
        }
    }

}
