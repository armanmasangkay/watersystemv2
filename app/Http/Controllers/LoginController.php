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
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect(route('login'))->withInput();
    }
}
