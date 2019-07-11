<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class IsAdminOrOperator
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
        if (Auth::user() &&  (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)) {
            return $next($request);
        }
        abort(403, 'Nemate prava pristupa' + Auth::user()->role_id);
    }
}
