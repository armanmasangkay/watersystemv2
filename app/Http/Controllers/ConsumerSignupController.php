<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumerSignupController extends Controller
{
    public function signUpPage()
    {
        return view('consumer-portal.signup');
    }
}
