<?php

namespace App\Http\Controllers;

use App\Classes\Facades\AccountNumber;
use App\Classes\Facades\BarangayData;
use App\Classes\Facades\CustomerDataHelper;
use App\Classes\Facades\CustomerRegistrationOptions;
use App\Exceptions\BarangayDoesNotExistException;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index()
    {

       return view('pages.consumer-data-entry',[
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

    public function getOnlyTransaction($customerId, $requestData)
    {
        $transaction = Arr::only($requestData, ['reading_meter', 'balance', 'reading_date', 'billing_meter_ips']);
        $transaction = Arr::add($transaction, 'reading_consumption', '0');
        $transaction = Arr::add($transaction, 'period_covered', 'Beginning Balance');
        $transaction = Arr::add($transaction, 'customer_id', $customerId);
        $transaction = Arr::add($transaction, 'user_id', Auth::id());
        return $transaction;
    }

    public function getOnlyCustomerInformation($requestData)
    {
        return Arr::except($requestData, ['last_meter_reading', 'balance', 'last_payment_date', 'billing_meter_ips']);
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
            'connection_status_specifics'=>'required_if:connection_status,others',
            'purchase_option'=>'required|in:cash,installment',
            'reading_meter' => 'required',
            'balance' => 'required|numeric',
            'reading_date' => 'required|date|after:yesterday'
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

            'purchase_option.required'=>'Purchase meter option must not be empty',
            'purchase_option.in'=>'Invalid purchase option selected',

            'reading_mter' => 'Meter reading must not be empty',
            'balance' => 'Current balance should not be empty',
            'reading_date' => 'Date of last payment should be today or later'

        ];
        $customerInfo = $this->getOnlyCustomerInformation($request->all());

        $requestsData=array_merge($customerInfo,['account_number'=>$accountNumber]);


       $validator=Validator::make($requestsData,$rules,$messages);



       if($validator->fails()){

           return response()->json([
               'created'=>false,
               'errors'=>$validator->errors()
           ]);
       }


       $normalizedData=CustomerDataHelper::normalize($requestsData);


        $customer = Customer::create($normalizedData);

        $transactions = $this->getOnlyTransaction($customer->account_number, $request->all());
        Transaction::create($transactions);



        return response()->json([
            'created'=>true
        ]);
    }
}
