<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class DefaultController extends Controller
{
    public function index()
    {
        $user = new User;
        $user->fname = "ahmed";
        $user->lname = "hazem";
        $user->email = "ahmed5000hazem@gmail.com";
        $user->password = bcrypt("1111");
        $user->phone = "01121143200";
        $user->address = "address";
        $user->city = "city";
        $user->save();

        $admin = new Role;
        $admin->name = 'admin';
        $admin->save();

        $user->attachRole($admin);

        $permission = new Permission;

        $permission->name = 'create-seller';

        $permission->save();

        $admin->attachPermission($permission);
    }
}
