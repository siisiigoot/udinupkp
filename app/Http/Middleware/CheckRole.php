<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if(auth()->user()->role == 'admin'){
            return $next($request);
           
        }
   
        return redirect('dashboard')->with('pesan','Anda tidak memilik akses ke halaman blablabla');
    }
}
