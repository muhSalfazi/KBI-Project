<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
{
    // Memisahkan role dengan '|' sebagai delimiter
    $roles = explode('|', $roles); 


    if (Auth::check() && in_array(Auth::user()->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Anda tidak memiliki akses ke halaman ini.');
}


}