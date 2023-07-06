<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class is_account_active
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
        $id = request()->segment(2);       
        if($id){
            $status = DB::table('manage_devices')->where('staff_id',$id)->value('status');
           
            if($status){
                 return $next($request);
             }else{
                abort(403, 'This account is not active yet');                
             }
        }else{
            abort(403, 'This is not valid link');
        }
       
    }
}
