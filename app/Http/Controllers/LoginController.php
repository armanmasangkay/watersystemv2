<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        $credentials=$request->only('username','password');
        if(Auth::attempt($credentials)){
            $request->session()->regenerate(); 
            
            if(Auth::user()->isCashier())
            {
                return redirect()->intended(route('admin.existing-customers.index'));
            }

            if(Auth::user()->isReader())
            {
                return redirect()->intended(route('home'));
            }

            return redirect()->intended(route('admin.dashboard'));
        //    return Auth::user()->isCashier() ? redirect()->intended(route('admin.existing-customers.index')):redirect()->intended(route('admin.dashboard'));
        }

        return redirect(route('login'))->withInput();
    }
}
