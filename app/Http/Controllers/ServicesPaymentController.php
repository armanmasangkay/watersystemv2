<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\PaymentWorkOrder;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ServiceRequest;

class ServicesPaymentController extends Controller
{
    public function index()
    {
        $services = Service::withStatus(Service::$PENDING_FOR_PAYMENT);
        return view('pages.users.cashier.services-transaction-payment', ['services' => $services, 'search_route' => 'admin.services-payment-search']);
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
        return view('pages.users.cashier.services-transaction-payment', ['services' => $services, 'route' => 'admin.services-payment-search']);
    }

    public function savePayment(ServiceRequest $request)
    {

        $service = Service::findOrFail($request->id);
        $service->approve();

        PaymentWorkOrder::create([
            'or_no' => $request->orNum,
            'customer_id' => $request->customer_id,
            'service_id' => $request->id,
            'payment_amount' => $request->amount,
            'user_id' => Auth::id()
        ]);

        return Response::json(['created' => true]);
    }
}
