<?php

namespace App\Http\Controllers;

use App\Classes\Facades\CustomerDataHelper;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Models\Transaction;
use App\Services\AccountNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function showAll()
    {
        $customers=Customer::paginate(10);
        return view('pages.customers-list',['customers'=>$customers]);
    }

    private function getOnlyTransaction($customerId, $requestData)
    {
        $transaction = Arr::only($requestData, ['reading_meter', 'balance', 'reading_date']);
        $transaction = Arr::add($transaction, 'billing_meter_ips', $requestData['billing_meter_ips'] ?? '0.00');
        $transaction = Arr::add($transaction, 'billing_amount', $requestData['balance'] ?? '0.00');
        $transaction = Arr::add($transaction, 'billing_surcharge', '0.00');
        $transaction = Arr::add($transaction, 'billing_total', $requestData['balance'] ?? '0.00');
        $transaction = Arr::add($transaction, 'reading_consumption', '0');
        $transaction = Arr::add($transaction, 'period_covered', 'Beginning Balance');
        $transaction = Arr::add($transaction, 'customer_id', $customerId);
        $transaction = Arr::add($transaction, 'user_id', Auth::id());
        $transaction = Arr::add($transaction, 'posted_by', Auth::id());
        return $transaction;
    }

    private function getOnlyCustomerInformation($requestData)
    {
        return Arr::except($requestData, ['reading_meter', 'balance', 'last_payment_date', 'billing_meter_ips']);
    }

    public function store(StoreCustomerRequest $request)
    {
       $normalizedData=CustomerDataHelper::normalize($request->all());
       $normalizedData['meter_number']=$request->meter_serial_number;
        $customer = Customer::create($normalizedData);
        $transactions = $this->getOnlyTransaction($customer->account_number, $request->all());
        Transaction::create($transactions);
        return response()->json([
            'created'=>true
        ]);
    }

    
}
