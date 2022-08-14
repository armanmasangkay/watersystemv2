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
                return redirect(route('admin.existing-customers.index'));
            }
            else if(Auth::user()->isReader())
            {
                return redirect(route('admin.home'));
            }
            else if(Auth::user()->isBuildingInspector())
            {
                return redirect(route('admin.request-approvals'));
            }
            else if(Auth::user()->isWaterworksInspector())
            {
                return redirect(route('admin.waterworks-request-approvals'));
            }
            else if(Auth::user()->isEngineer())
            {
                return redirect(route('admin.municipal-engineer.index'));
            }
            else if(Auth::user()->isAccountOfficer())
            {
                return redirect('/account-officer/dashboard');
            }
            else
            {
                return redirect(route('admin.dashboard'));
     
            }
        }

        return redirect(route('login'))->withInput();
    }
}
