<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\WaterRate;
use App\Models\Transaction;
use App\Models\Payments;
use App\Models\Surcharge;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
        // $transactions = $customer->transactions()->orderBy('created_at', 'asc')->paginate(10)->appends(['account_number'=>$account_number]);

        $balance = Transaction::orderByDesc('created_at')->where('customer_id', $account_number)->get();
        $balance = $balance->first();

        $transactions = Transaction::orderBy('created_at', 'asc')->where('customer_id', $account_number)->paginate(10);

        $rate = [];

        $rates = WaterRate::all();


        for($i = 0; $i < count($rates); $i++)
        {
            if(Str::title($customer->connection_type) == $rates[$i]->type)
            {
                $rate = [
                    'min_rate' => $rates[$i]->min_rate,
                    'max_range' => $rates[$i]->consumption_max_range,
                    'excess_rates' => $rates[$i]->excess_rate
                ];
            }
        }

        $surcharge = Surcharge::all();
        // $payments = Payments

        $date = ($balance->period_covered != "Beginning Balance" ? explode('-', $balance->period_covered) : explode('/', '/'.$balance->reading_date));

        return view('pages.consumer-ledger',[
            'customer' => [
                'fullname' => $fullname,
                'address' => $address,
                'transactions' => $transactions,
                'account' => $acc,
                'balance' => $balance,
                'connection_type' => $customer->connection_type,
                'org_name'=>$customer->org_name
            ],
            'rates' => $rate,
            'surcharge' => $surcharge[0]->rate,
            'last_date' => $date[1],
            'route' => 'admin.search-transactions',
            'current_transaction_id' => $balance->id
        ]);
    }

    public function store(Request $request)
    {
        $fillable=[
            'customer_id' => $request->customer_id,
            'period_covered' => $request->current_month.'-'.$request->next_month,
            'reading_date' => date('Y-m-d', strtotime($request->reading_date)),
            'reading_meter' => $request->reading_meter,
            'reading_consumption' => $request->consumption,
            'billing_amount' => $request->amount,
            'billing_surcharge' => '0.00',
            'billing_meter_ips' => $request->meter_ips,
            'billing_total' => $request->total,
            'balance' => $request->total,
            'posted_by' => Auth::id(),
            'user_id' => Auth::id(),
        ];

        $update_transaction = Transaction::find($request->current_transaction_id);
        $update_transaction->billing_surcharge = $request->surcharge_amount;
        $update_transaction->billing_total += $request->surcharge_amount;
        $update_transaction->balance += $request->surcharge_amount;
        $update_transaction->update();

        $transactions = Transaction::create($fillable);
        return response()->json(['created' => true]);
    }
}
