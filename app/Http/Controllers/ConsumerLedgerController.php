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
    public $waterbill;

    public function __construct()
    {
        $this->waterbill = new WaterBill();
    }

    public function toAccounting($num){ return number_format($num, 2, '.', ','); }

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
        $dates = [];
        
        if(!empty($balance->period_covered))
        {
            $date = ($balance->period_covered != "Beginning Balance" ? explode('-', $balance->period_covered) : explode('/', '/'.$balance->reading_date));
            $dates = $date[1];
        }

        // dd($transactions->toArray());

        return view('pages.consumer-ledger',[
            'customer' => [
                'fullname' => $fullname,
                'address' => $address,
                'transactions' => $transactions,
                'account' => $acc,
                'balance' => !empty($balance) ? $balance : '',
                'connection_type' => $customer->connection_type,
                'org_name'=>$customer->org_name
            ],
            'rates' => $rate,
            'surcharge' => $surcharge[0]->rate,
            'last_date' => !empty($balance->period_covered) ? $dates : date('Y-m-d', strtotime('now')),
            'route' => 'admin.search-transactions',
            'current_transaction_id' => !empty($balance->id) ? $balance->id : 0
        ]);
    }

    public function store(Request $request)
    {
        if(isset($request->rd_date))
        {
            $prev_period_covered = explode('-', $request->rd_date);
            $previous_year = explode(', ', $prev_period_covered[1]);
            $new_covered_date_beginning = $prev_period_covered[0]. ', '.$previous_year[1];
        
            if( \Carbon\Carbon::parse($request->reading_date) >= \Carbon\Carbon::parse($new_covered_date_beginning) && 
                \Carbon\Carbon::parse($request->reading_date) <= \Carbon\Carbon::parse($prev_period_covered[1]) )
            {
                return response()->json(['created' => false, 'msg' => 'Cannot create billing, make sure that the reading date is not covered from the previous reading date.']);
            }
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'current_transaction_id' => 'required',
            'current_month' => 'required',
            'next_month' => 'required',
            'reading_date' => 'required',
            'reading_meter' => 'required|numeric|gt:0',
            'consumption' => 'required|numeric',
            'amount' => 'required|numeric|gt:0',
            'meter_ips' => 'required|numeric',
            'total' => 'required|numeric|gt:0',
        ]);

        if($validator->fails()){
            return response()->json(['created' => false, 'msg' => $validator->errors()]);
        }

        if($request->reading_meter < $request->meter_reading)
        {
            return response()->json(['created' => false, 'msg' => 'Current meter reading should not be less than the previous meter reading.']);
        }

        $this->waterbill->getConnectionType($request->customer_id);
        $this->waterbill->getCurrentBalance($request->customer_id);
        $this->waterbill->computeBillConsumption($request->reading_meter);

        $fillable=[
            'customer_id' => $this->waterbill->balance != null ? $this->waterbill->balance->customer_id : $request->customer_id,
            'period_covered' => $request->current_month.'-'.$request->next_month,
            'reading_date' => date('Y-m-d', strtotime($request->reading_date)),
            'reading_meter' => $request->reading_meter,
            'reading_consumption' => $this->waterbill->computed_total['meter_consumption'],
            'billing_amount' => $this->waterbill->computed_total['amount_consumption'],
            'billing_surcharge' => '0.00',
            'billing_meter_ips' => $this->waterbill->balance != null ? $this->waterbill->balance->billing_meter_ips : $request->meter_ips,
            'billing_total' => $this->waterbill->computed_total['total'],
            'balance' => $this->waterbill->computed_total['total'],
            'posted_by' => Auth::id(),
            'user_id' => Auth::id(),
        ];

        if($this->waterbill->balance != null)
        {
            $update_transaction = Transaction::findOrFail($this->waterbill->balance->id);

            $update_transaction->billing_surcharge = $this->waterbill->computed_total['surcharge'];
            $update_transaction->billing_total += $this->waterbill->computed_total['surcharge'];
            $update_transaction->balance += $this->waterbill->computed_total['surcharge'];
            $update_transaction->update();
        }

        $transactions = Transaction::create($fillable);
        return response()->json(['created' => true/*, 'data' => $this->waterbill->computed_total*/]);
    }
}
