<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,...$role)
    {
        $authenticatedUserRole=auth()->user()->role;

        $isAllowed=in_array($authenticatedUserRole,$role);

        if(!$isAllowed)
        {
            abort(403,'Your account type is not allowed to access this URL');
        }

        return $next($request);
    }
}
