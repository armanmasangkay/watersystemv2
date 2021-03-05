<?php

namespace App\Http\Controllers;

use App\Classes\Facades\AccountNumber;
use App\Classes\Facades\BarangayData;
use App\Classes\Facades\CustomerDataHelper;
use App\Classes\Facades\CustomerRegistrationOptions;
use App\Exceptions\BarangayDoesNotExistException;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

    public function index()
    {
      
       return view('pages.customer-registration',[
        'civilStatuses'=>CustomerRegistrationOptions::civilStatuses(),
        'barangays'=>CustomerRegistrationOptions::barangays(),
        'connectionTypes'=>CustomerRegistrationOptions::connectionTypes(),
        'connectionStatuses'=>CustomerRegistrationOptions::connectionStatuses()
        ]);
    }

    public function showAll()
    {
        $customers=Customer::paginate(10);
        
        return view('pages.customers-list',['customers'=>$customers]);
    }

    public function store(Request $request)
    { 
        $brgyCode=BarangayData::getCodeByName($request->barangay);
        $accountNumber=AccountNumber::new(strval($brgyCode),BarangayData::numberOfPeopleOn($request->barangay));
       
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
            'connection_type_specifics'=>'required_if:connection_type,others',

            'connection_status'=>'required',
            'connection_status_specifics'=>'required_if:connection_status,others'
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
            'connection_type_specifics.required_if'=>'Specific connection type must be provided if "OTHERS" is selected',
                
            'connection_status.required'=>'Connection Status must not be empty',
            'connection_status_specifics.required_if'=>'Specific connection status must be provided if "OTHERS" is selected',

        ];
        $requestsData=array_merge($request->all(),['account_number'=>$accountNumber]);
          
    
       $validator=Validator::make($requestsData,$rules,$messages);



       if($validator->fails()){

           return response()->json([
               'created'=>false,
               'errors'=>$validator->errors()
           ]);
       }


       $normalizedData=CustomerDataHelper::normalize($requestsData);
       

        Customer::create($normalizedData);

        return response()->json([
            'created'=>true
        ]);
    }
}
