<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestricCashier
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
        if(auth()->user()->isCashier()){
            // abort(403,"You are not allowed to access this URL.");
            return redirect(route('admin.existing-customers.index'));
        }

        return $next($request);
    }
}
