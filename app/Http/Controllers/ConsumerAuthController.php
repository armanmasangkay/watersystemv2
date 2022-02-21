<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumerAuthController extends Controller
{
    public function signInPage()
    {
        return view('consumer-portal.login');
    }

    public function signIn(Request $request)
    {
        
        $credentials=$request->validate([
            'account_number'=>['required'],
            'password'=>['required'],
        ]);

        if(!Auth::guard('accounts')->attempt($credentials))
        {

            return back()->withErrors([
                'account_number'=>'The provided credentials do not match our records.',
            ])->withInput();
           
        }

        if(Auth::guard('accounts')->user()->status==Account::STATUS_PENDING){
            return back()->withErrors([
                'account_number'=>'This account is not approved yet. Please check your account from time to time!',
            ])->withInput();
        }

        $request->session()->regenerate();
        return redirect(route('consumer.dashboard'));

        
    }

    public function signout(Request $request)
    {
        Auth::guard("accounts")->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('consumer.signin.index'));

    }
}
