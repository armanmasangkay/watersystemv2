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
        $transactions=Transaction::whereBetween('created_at',[$from,$to])
                                ->where('customer_id',Auth::guard("accounts")->user()->account_number)
                                ->get();
        return view("consumer-portal.dashboard",[
            "transactions"=>$transactions
        ]);
    }

    public function latestBill()
    {
        $transaction=Transaction::where('customer_id',Auth::guard("accounts")->user()->account_number)
                                ->orderBy('created_at','desc')
                                ->first();


                            //TODO: Get the latest Bill
       return view("consumer-portal.latest",[
           'transaction'=>$transaction
       ]);
    }
}
