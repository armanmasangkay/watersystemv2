<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumerAuthController extends Controller
{
    public function loginPage()
    {
        return view('consumer-portal.login');
    }
}
