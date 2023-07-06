<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use DB;

class is_staff_active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $status = DB::table('staff')->where('id',Auth::guard('staff')->user()->id)->value('status');

        if($status){
            return $next($request);
        }else{
            Auth::guard('staff')->logout();
            return redirect()->route('Staff_login')->with('message',"Your Account Is not active yet");
        }
    }
}
