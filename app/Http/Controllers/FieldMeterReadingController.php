<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\WaterRate;
use App\Models\Transaction;
use App\Models\Surcharge;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class FieldMeterReadingController extends Controller
{
    public $waterbill;

    public function __construct()
    {
        $this->waterbill = new WaterBillController();
    }

    public function toAccounting($num){ return number_format($num, 2, '.', ','); }

    public function index()
    {
        return view('field-personnel.pages.meter-reading');
    }

    private function countUnreadMeters()
    {
        $customers = Customer::all();
        $index = 0;
        $customersLists = [];

        if(isset($customers) || !empty($customers) || $customers != null)
        {
            for($i = 0; $i < $customers->count(); $i++)
            {
                $balance = Transaction::orderByDesc('created_at')->where('customer_id', $customers[$i]->account())->get();
                $balance = $balance->first();

                if(isset($balance) || !empty($balance) || $balance != null)
                {
                    $monthNow = date('m');
                    $dayNow = date('d');
                    $prevMonth = date('t', strtotime($balance->reading_date));
                    $prevDay = date('d', strtotime($balance->reading_date));

                    if((($prevMonth - $prevDay) + $dayNow) >= 33)
                    {
                        $customersLists[$index] = $customers[$i];
                        $index++;
                    }
                }
            }
        }

        return $customersLists;
    }

    public function home()
    {
        return view('field-personnel.pages.home', ['notif' => count($this->countUnreadMeters()) ?? 0]);
    }

    public function overdueReading()
    {
        return view('field-personnel.pages.unread-meter', ['customers' => $this->countUnreadMeters(), 'notif' => count($this->countUnreadMeters()) ?? 0]);
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'barangay' => 'required',
            'purok' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['filtered' => false, 'errors' => $validator->errors()]);
        }

        $data = Customer::where('purok' , $request->purok)->where('barangay' , $request->barangay)->where('connection_status', Customer::ACTIVE)->get();

        return response()->json(['filtered' => true, 'data' => $data]);
    }

    public function search(Request $request)
    {
        $account_number=$request->account_number;

        try{
            $customer=Customer::findOrFail($account_number);
        }catch(ModelNotFoundException $e){
            return back()->withErrors([
                'account_number.exists'=>'Account number not found'
            ])->withInput();
        }

        if(!$customer->hasActiveConnection())
        {
            return back()->withErrors([
                'account_number'=>'Account is not active'
            ])->withInput();
        }

        $acc = $customer->account();
        $fullname = $customer->fullname();
        $address = $customer->address();
        $meter_sn = $customer->meter_number;

        $balance = Transaction::orderByDesc('created_at')->where('customer_id', $account_number)->get();
        $new_balance = $balance->first();

        $transactions = Transaction::orderBy('created_at', 'asc')->where('customer_id', $account_number)->paginate(10);

        $rate = [];

        $rates = WaterRate::all();

        foreach($rates as $r)
        {
            if(Str::title($customer->connection_type) == $r->type)
            {
                $rate = [
                    'min_rate' => $r->min_rate,
                    'max_range' => $r->consumption_max_range,
                    'excess_rates' => $r->excess_rate
                ];
            }
        }

        $surcharge = Surcharge::all();
        $date = "";
        // $payments = Payments
        if(count($balance->toArray()) > 0)
        {
            $date = ($new_balance->period_covered != "Beginning Balance" ? explode('-', $new_balance->period_covered) : explode('/', '/'.$new_balance->reading_date));
        }
        else
        {
            $date = explode('/', '/'.date('Y-m-d'));
        }

        return view('field-personnel.pages.meter-reading',[
            'customer' => [
                'fullname' => $fullname,
                'address' => $address,
                'transactions' => $transactions,
                'account' => $acc,
                'meter_number' => $meter_sn,
                'balance' => $new_balance,
                'connection_type' => $customer->connection_type,
                'org_name'=>$customer->org_name,
                'serial_number' => $customer->meter_number
            ],
            'rates' => $rate,
            'surcharge' => $surcharge[0]->rate,
            'last_date' => count($balance->toArray()) ? $date[1] : null,
            'current_transaction_id' => isset($balance->id) ? $balance->id : null
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
        // i need to remove the toAccounting because it throws a 500 error
        // please accept this changes
        $update_transaction->billing_surcharge = $this->waterbill->computed_total['surcharge'];
        $update_transaction->billing_total += $this->waterbill->computed_total['surcharge'];
        $update_transaction->balance += $this->waterbill->computed_total['surcharge'];
        $update_transaction->update();


        $transactions = Transaction::create($fillable);
        return response()->json(['created' => true, 'data'=>$fillable]);
    }
}
