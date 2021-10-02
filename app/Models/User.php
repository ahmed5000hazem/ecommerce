<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mindscms\Entrust\Traits\EntrustUserWithPermissionsTrait;
class User extends Authenticatable
{
    use Notifiable, EntrustUserWithPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany("App\Models\Order");
    }
    
    public function supervisorOrders()
    {
        return $this->hasMany("App\Models\Order", "supervisor_id");
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public static function searchUsers ($expression, $dataBinding = []) {
        return self::whereRaw($expression, $dataBinding)->orderBy("id")->get();
    }

}
