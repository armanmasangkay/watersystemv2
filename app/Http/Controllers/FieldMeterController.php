<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldMeterController extends Controller
{
    public function index()
    {
        return view('field-personnel.pages.home');
    }
}
