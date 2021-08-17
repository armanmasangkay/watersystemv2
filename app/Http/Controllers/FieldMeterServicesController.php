<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\WaterRate;
use App\Models\Transaction;
use App\Models\Surcharge;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class FieldMeterServicesController extends Controller
{
    public function index()
    {
        return view('field-personnel.pages.services');
    }

    public function search(Request $request)
    {
        $account_number=$request->account_number??$request->account_number;
        
        try{
            $customer=Customer::findOrFail($account_number);
        }catch(ModelNotFoundException $e){
            return back()->withErrors([
                'account_number.exists'=>'Account number not found'
            ])->withInput();
        }

        $acc = $customer->account();
        $fullname = $customer->fullname();
        // $transactions = $customer->transactions()->orderBy('created_at', 'asc')->paginate(10)->appends(['account_number'=>$account_number]);

        return view('field-personnel.pages.services',[
            'customer' => [
                'fullname' => $fullname,
                'account' => $acc,
                'org_name'=>$customer->org_name
            ]
        ]);
    }
}