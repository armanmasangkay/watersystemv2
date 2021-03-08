<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
{
    public function search(Request $request)
    {
        try{
            $customer=Customer::findOrFail($request->account_number);

        }catch(ModelNotFoundException $e)
        {
            return view('pages.customer-not-found',['account_number'=>$request->account_number]);
        }
     

        return view('pages.new-transaction',[
            'customer'=>$customer
        ]);

    }
}
