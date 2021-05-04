<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransferOfMeterController extends Controller
{
    //transfer-meter
    public function index()
    {
        return view('pages.transfer-meter', ['route' => 'admin.search-info', 'search_heading' => 'SEARCH REQUEST']);
    }

    public function search(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'account_number'=>'required|exists:customers,account_number'
        ],[
           'account_number.exists'=>'Account number not found' 
        ]);

        if($validator->fails()){
            return redirect(route('admin.search-info'))->withErrors($validator)->withInput();
           
        }
        $customer=Customer::find($request->account_number);

        session()->flashInput(['account_number'=>$request->account_number]);
    
        return view('pages.transfer-meter',[
            'customer'=>$customer,
            'route' => 'admin.search-info'
        ]);

    }
}
