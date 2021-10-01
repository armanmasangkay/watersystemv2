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
            else if(Auth::user()->isReader())
            {
                return redirect()->intended(route('admin.home'));
            }
            else if(Auth::user()->isBuildingInspector())
            {
                return redirect()->intended(route('admin.request-approvals'));
            }
            else if(Auth::user()->isWaterworksInspector())
            {
                return redirect()->intended(route('admin.waterworks-request-approvals'));
            }
            else if(Auth::user()->isEngineer())
            {
                return redirect()->intended(route('admin.municipal-engineer.index'));
            }
            else
            {
                return redirect()->intended(route('admin.dashboard'));
     
            }
        }

        return redirect(route('login'))->withInput();
    }
}
