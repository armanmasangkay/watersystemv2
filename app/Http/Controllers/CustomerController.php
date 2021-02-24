<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $rules=[
            'account_number'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'civil_status'=>'required',
            'purok'=>'required',
            'barangay'=>'required',
            'contact_number'=>'required',
            'connection_type'=>'required',
            'connection_status'=>'required'
        ];

        $messages=[
            'account_number.required'=>'Account number must not be empty',
            'firstname.required'=>'First name must not be empty',
            'lastname.required'=>'Last name must not be empty',
            'civil_status.required'=>'Civil status must not be empty',
            'purok.required'=>'Purok must not be empty',
            'barangay.required'=>'Barangay must not be empty',
            'contact_number.required'=>'Contact number must not be empty',
            'connection_type.required'=>'Connection type must not be empty',
            'connection_status.required'=>'Connection Status must not be empty'

        ];
    
       $validator=Validator::make($request->all(),$rules,$messages);

       if($validator->fails()){
           return response()->json([
               'created'=>false,
               'errors'=>$validator->errors()
           ]);
       }

        Customer::create($request->all());

        return response()->json([
            'created'=>true
        ]);
    }
}
