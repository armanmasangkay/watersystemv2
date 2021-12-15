<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedAccount
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
    
        if(!Auth::guard('accounts')->user()){
           
            return redirect(route('consumer.signin.index'))
                    ->with([
                        'message'=>'You must sign in first.'
                    ]);
        }
        return $next($request);
    }
}
