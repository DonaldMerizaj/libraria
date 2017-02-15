<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Utils;
use Closure;
use Illuminate\Support\Facades\Redirect;

class isLogged
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
        //nese ka id_login ne session, vazhdo, perndryshe rikthe ne faqen e loginit
        if ( Utils::isLogged()) {
            return $next($request);
        }else{
            return Redirect::route('loginView');
        }
    }
}
