<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowedAccessGroupAdmin
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
        if ( Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isCashier()) || Auth::user()->isBuildingInspector() || Auth::user()->isWaterworksInspector() )
        {
            return $next($request);
        }

        return redirect(route('home'));
    }
}
