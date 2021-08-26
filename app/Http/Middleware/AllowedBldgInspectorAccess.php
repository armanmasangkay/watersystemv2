<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedBldgInspectorAccess
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
        if(!auth()->user()->isBuildingInspector())
        {
            return back();
        }

        return $next($request);
    }
}
