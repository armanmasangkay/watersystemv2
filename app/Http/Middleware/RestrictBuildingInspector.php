<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictBuildingInspector
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
        if(auth()->user()->isBuildingInspector()){
            return redirect(route('admin.request-approvals'));
        }
        return $next($request);
    }
}
