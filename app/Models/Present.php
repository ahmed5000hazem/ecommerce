<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    public $table = "presentes";
    protected $fillable = [
        "product_id",
        "order_id",
        "color_id",
        "size_id",
        "presents_count",
    ];

    public function color()
    {
        return $this->belongsTo("App\Models\Color");
    }
    public function size()
    {
        return $this->belongsTo("App\Models\Size");
    }

}
