<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        //if(Utils::getRole(Session("userId')) == Utils::ADMIN){
            return $next($request);
        //}else{
        //        return Redirect::back();
        //}

    }
}
