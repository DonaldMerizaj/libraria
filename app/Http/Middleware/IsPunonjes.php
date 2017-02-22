<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Classes\LoginClass;
use App\Http\Controllers\Classes\UserClass;
use App\Http\Controllers\Utils;
use Closure;
use Illuminate\Support\Facades\Redirect;

class IsPunonjes
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
        if ( Utils::getRole() <= LoginClass::PUNONJES){
            return $next($request);
        }else{
            return Redirect::back();
        }
    }
}
