<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class authcheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('email')){
            return redirect('/')->with('fail','Voce não está logado!');
        }
        return $next($request);
    }
}
