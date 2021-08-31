<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\WaterRate;
use App\Models\Transaction;
use App\Models\Payments;
use App\Models\Surcharge;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FieldMeterReadingController extends Controller
{
    public $waterbill;

    public function __construct()
    {
        $this->waterbill = new WaterBill();
    }

    public function toAccounting($num){ return number_format($num, 2, '.', ','); }

    public function index()
    {
        return view('field-personnel.pages.meter-reading');
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

        return view('field-personnel.pages.meter-reading',[
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
            'current_transaction_id' => $balance->id
        ]);
    }

    public function store(Request $request)
    {
        if(isset($request->read_date))
        {
            if( \Carbon\Carbon::parse($request->current_month) >= $request->read_date && 
                \Carbon\Carbon::parse($request->next_month) <= $request->read_date )
            {
                return response()->json(['created' => false, 'msg' => 'Cannot create billing, make sure that the reading date is not covered from the previous reading date.']);
            }
        }

        if($request->reading_meter < $request->meter_reading)
        {
            return response()->json(['created' => false, 'msg' => 'Current meter reading should not be less than the previous meter reading.']);
        }

        $this->waterbill->getConnectionType($request->customer_id);
        $this->waterbill->getCurrentBalance($request->customer_id);
        $this->waterbill->computeBillConsumption($request->reading_meter);

        $fillable=[
            'customer_id' => $this->waterbill->balance->customer_id,
            'period_covered' => $request->current_month.'-'.$request->next_month,
            'reading_date' => date('Y-m-d', strtotime($request->read_date)),
            'reading_meter' => $request->reading_meter,
            'reading_consumption' => $this->waterbill->computed_total['meter_consumption'],
            'billing_amount' => $this->waterbill->computed_total['amount_consumption'],
            'billing_surcharge' => '0.00',
            'billing_meter_ips' => $this->waterbill->balance->billing_meter_ips,
            'billing_total' => $this->waterbill->computed_total['total'],
            'balance' => $this->waterbill->computed_total['total'],
            'posted_by' => $request->id,
            'user_id' => $request->id,
        ];

        $update_transaction = Transaction::findOrFail($this->waterbill->balance->id);

        $update_transaction->billing_surcharge = $this->toAccounting($this->waterbill->computed_total['surcharge']);
        $update_transaction->billing_total += $this->toAccounting($this->waterbill->computed_total['surcharge']);
        $update_transaction->balance += $this->toAccounting($this->waterbill->computed_total['surcharge']);
        $update_transaction->update();


        $transactions = Transaction::create($fillable);
        return response()->json(['created' => true, 'data'=>$fillable]);
    }
}
