<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ConsumerDashboardController extends Controller
{
    public function dashboard()
    {
        $from=now()->subYear(1);
        $to=now();
        $transactions=Transaction::whereBetween('created_at',[$from,$to])->get();
        return view("consumer-portal.dashboard",[
            "transactions"=>$transactions
        ]);
    }
}
