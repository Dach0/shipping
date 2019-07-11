<?php

namespace App\Http\Middleware;

use Closure;

class IsAdminOrSales
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
        if (Auth::user() &&  (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)) {
            return $next($request);
        }
        abort(403, 'Access denied');
    }
}
