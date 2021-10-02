<?php 

namespace App\Models;
use Mindscms\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
