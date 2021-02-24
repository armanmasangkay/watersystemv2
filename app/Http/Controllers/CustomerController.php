<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        Customer::create($request->all());

        return response()->json([
            'created'=>true
        ]);
    }
}
