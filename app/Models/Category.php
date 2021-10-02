<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function parent () {
        return $this->belongsTo("App\Models\Category", "parent_id", "id");
    }

    public function children()
    {
        return $this->hasMany("App\Models\Category", "parent_id", "id");
    }

    public function products()
    {
        return $this->hasMany("App\Models\Product");
    }

    public function getFeaturedProducts()
    {
        return $this->products()->where([
            ["is_featured", 1],
            ["active", 1],
        ]);
    }
}
