<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistroy
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
       $response = $next($request);
       return $response->header('Cache-Control' , 'nocache,on-store,max-age=0,must-revaildate')
                       ->header('Pragma','no-cache')
                       ->header('Expires','sun,02 Jan 1990 00:00:00 GMT');
    }
}
