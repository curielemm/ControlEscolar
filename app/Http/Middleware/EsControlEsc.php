<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class EsControlEsc
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
        $user = Auth::user();
        // $user2 = new User();
         if(!$user->esControlEsc()){
             return redirect('/noAutorizado');
         }
        return $next($request);
    }
}
