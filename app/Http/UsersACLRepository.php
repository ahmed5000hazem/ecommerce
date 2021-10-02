<?php

namespace App\Http;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use Illuminate\Support\Facades\Auth;
class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules() : array
    {
        if (auth()->user()->hasRole("seller")) {
            return [
                ['disk' => 'product-images', 'path' => '/', 'access' => 1],
                ['disk' => 'product-images', 'path' => 'sellers', 'access' => 2],
                ['disk' => 'product-images', 'path' => 'sellers/'. Auth::user()->id, 'access' => 1],        // only read
                ['disk' => 'product-images', 'path' => 'sellers/'. Auth::user()->id .'/*', 'access' => 1],  // read and write
            ];
        } elseif (auth()->user()->hasRole("admin")) {
            return [
                ['disk' => 'product-images', 'path' => '*', 'access' => 2],
            ];
        }
        
    }
}