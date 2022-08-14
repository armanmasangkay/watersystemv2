<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumerDashboardController extends Controller
{
    public function dashboard()
    {
        $from=now()->subYear(1);
        
        $to=now();

        $userAccountNumber = Auth::guard("accounts")->user()->account_number;

        $transactions=Transaction::whereBetween('created_at',[$from, $to])
                                ->where('customer_id', $userAccountNumber)
                                ->get();

        return view("consumer-portal.dashboard",[
            "transactions"=>$transactions
        ]);
    }

    public function latestBill()
    {
        $userAccountNumber = Auth::guard("accounts")->user()->account_number;

        $transaction=Transaction::where('customer_id', $userAccountNumber)
                                ->orderBy('created_at','desc')
                                ->first();


       return view("consumer-portal.latest", [
           'transaction'=>$transaction
       ]);
    }
}
