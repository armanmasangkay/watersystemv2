<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class ServicesPaymentController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'pending_for_payment')->paginate(20);
        return view('pages.cashier-services-transaction-payment', ['services' => $services, 'route' => 'admin.services-payment-search']);
    }

    public function search(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'account_number'=>'required|exists:customers,account_number'
        ],[
           'account_number.exists'=>'Account number not found'
        ]);

        if($validator->fails()){
            return redirect(route('admin.services-payment'))->withErrors($validator)->withInput();
        }

        $customer=Customer::find($request->account_number);
        session()->flashInput(['account_number'=>$request->account_number]);

        $services = Service::where('status', 'pending_for_payment')->where('customer_id', $request->account_number)->get();
        return view('pages.cashier-services-transaction-payment', ['services' => $services, 'route' => 'admin.services-payment-search']);
    }
}
