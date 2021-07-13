<?php

namespace App\Http\Controllers;

use App\Classes\Facades\AccountNumber;
use App\Classes\Facades\BarangayData;
use App\Classes\Facades\CustomerDataHelper;
use App\Classes\Facades\CustomerRegistrationOptions;
use App\Models\Customer;
use App\Models\Transaction;
use App\Services\AccountNumberService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExistingCustomerController extends Controller
{

    public function index()
    {
        $customers=Customer::paginate(10);
        return view('pages.customers-list',['customers'=>$customers]);
    }

    public function create()
    {
    
        return view('pages.consumer-data-entry',[
            'civilStatuses'=>CustomerRegistrationOptions::civilStatuses(),
            'barangays'=>CustomerRegistrationOptions::barangays(),
            'connectionTypes'=>CustomerRegistrationOptions::connectionTypes(),
            'connectionStatuses'=>CustomerRegistrationOptions::connectionStatuses()
        ]);
    }
}
