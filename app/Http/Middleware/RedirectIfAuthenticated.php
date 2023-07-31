<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
          
        if (Auth::guard($guard)->check()) {
            $user = Auth::user()->id;
            $correo = User::where("id","=",$user)->get()->toArray();
            if($correo[0]['role_id']==1){
                return redirect()->route('dashboard');
              }elseif($correo[0]['role_id']==2){
                return redirect()->route('dashboardAnalista');
              }elseif($correo[0]['role_id']==3){
                return redirect()->route('dashboardCtrlEscolar');
              }
        }

        return $next($request);
    }
}
