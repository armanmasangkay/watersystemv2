<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Facades\CustomerRegistrationOptions;
use App\Http\Requests\NewConnectionRequest;
use App\Models\Customer;
use App\Models\Service;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\Auth;

class NewConnectionController extends Controller
{
    public function create(){
        return view('pages.new-consumer',[
            'civilStatuses'=>CustomerRegistrationOptions::civilStatuses(),
            'barangays'=>CustomerRegistrationOptions::barangays(),
            'connectionTypes'=>CustomerRegistrationOptions::connectionTypes(),
            'connectionStatuses'=>CustomerRegistrationOptions::connectionStatuses()
        ]);
    }

    public function store(NewConnectionRequest $request){

        $requestData = $request->all();
        $requestData['connection_status'] = 'inactive';

        $customer = Customer::create($requestData);
        Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'contact_number' => $requestData['contact_number'],
            'status' => 'new_connection'
        ]);
        TransactionLog::create([
            'customer_organization_name' => $requestData['org_name'] ?? '',
            'customer_firstname' => $requestData['firstname'],
            'customer_middlename' => $requestData['middlename'],
            'customer_lastname' => $requestData['lastname'],
            'type_of_transaction' => $requestData['connection_type'],
            'issued_by' => Auth::id()
        ]);
        return response()->json(['created' => true]);
    }
}
