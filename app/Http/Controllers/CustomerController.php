<?php

namespace App\Http\Controllers;

use App\Classes\Facades\BarangayData;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

    public function index()
    {
       
    }

    public function store(Request $request)
    {
        $rules=[
            'account_number'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'civil_status'=>'required|in:married,single,widowed',
            'purok'=>'required',
            'barangay'=>[
                'required',
                Rule::in(BarangayData::names())
            ],
            'contact_number'=>'required|numeric|digits:11',
            'connection_type'=>'required',
            'connection_status'=>'required'
        ];

        $messages=[
            'account_number.required'=>'Account number must not be empty',
            'firstname.required'=>'First name must not be empty',
            'lastname.required'=>'Last name must not be empty',

            //Civil status validation
            'civil_status.required'=>'Civil status must not be empty',
            'civil_status.in'=>'Invalid civil status value',

            'purok.required'=>'Purok must not be empty',

            //Barangay validation
            'barangay.required'=>'Barangay must not be empty',
            'barangay.in'=>'Invalid barangay value',


            //Contact number validation
            'contact_number.required'=>'Contact number must not be empty',
            'contact_number.numeric'=>'Contact number must only contain numbers',
            'contact_number.digits'=>'Contact number should be 11 digits',


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
