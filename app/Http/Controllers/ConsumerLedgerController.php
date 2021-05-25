<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsumerLedgerController extends Controller
{
    public function index()
    {
        return view('pages.consumer-ledger', ['route' => 'admin.search-transactions']);
    }

    public function search(Request $request)
    {
        $account_number=$request->account_number??$request->account_number;

        try{
            $customer=Customer::findOrFail($account_number);

        }catch(ModelNotFoundException $e){
            return redirect(route('admin.consumer-ledger'))->withErrors([
                'account_number.exists'=>'Account number not found'
            ])->withInput();
        }

        $acc = $customer->account();
        $fullname = $customer->fullname();
        $address = $customer->address();
        $transactions = $customer->transactions()->paginate(10)->appends(['account_number'=>$account_number]);

        $balance = Transaction::orderByDesc('created_at')->where('customer_id', $account_number)->get();
        $balance = $balance->first();

        return view('pages.consumer-ledger',[
            'customer' => [
                'fullname' => $fullname, 
                'address' => $address, 
                'transactions' => $transactions, 
                'account' => $acc, 
                'balance' => $balance
            ],
            'route' => 'admin.search-transactions',
        ]);
    }
}
