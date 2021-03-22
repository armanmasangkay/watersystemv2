<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerSearchController extends Controller
{
    public function search(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'account_number'=>'required|exists:customers,account_number'
        ],[
           'account_number.exists'=>'Account number not found' 
        ]);

        if($validator->fails()){
            return redirect(route('admin.transactions.create'))->withErrors($validator)->withInput();
           
        }
        $customer=Customer::find($request->account_number);

        session()->flashInput(['account_number'=>$request->account_number]);
    
        return view('pages.new-transaction',[
            'customer'=>$customer
        ]);

    }
}
