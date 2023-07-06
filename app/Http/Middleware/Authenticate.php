<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $current_uri = request()->segments();        
        if (! $request->expectsJson()) {
            if($current_uri[0] == "Staff"){
                return route('Staff_login');
            }
            elseif($current_uri[0] == "Restaurant"){
                return route('Restaurant_login');
            }
            elseif($current_uri[0] == "Admin"){
                return route('admin_login');
            }            
        }
    }
}
