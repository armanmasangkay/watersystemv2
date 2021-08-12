<?php 

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Surcharge;
use App\Models\Transaction;
use App\Models\WaterRate;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WaterBill extends Controller{

    public $surcharge = [];
    public $rates = [];
    public $connection_type;
    public $rate = [];
    public $balance = [];
    public $computed_total = [];
    public $reading_meter;

    public function __construct()
    {
        $this->rates = WaterRate::all();
        $this->surcharge = Surcharge::all();
    }

    public function getConnectionType($account_number)
    {
        $customer = Customer::findOrFail($account_number);

        for($i = 0; $i < count($this->rates); $i++)
        {
            if(Str::title($customer->connection_type) == $this->rates[$i]->type)
            {
                $this->rate = [
                    'min_rate' => $this->rates[$i]->min_rate,
                    'max_range' => $this->rates[$i]->consumption_max_range,
                    'excess_rates' => $this->rates[$i]->excess_rate
                ];
            }
        }
    }

    public function getCurrentBalance($account_number)
    {
        $bal = Transaction::orderByDesc('created_at')->where('customer_id', $account_number)->get();
        $this->balance = $bal->first();
    }

    public function computeWaterBill(Request $request)
    {
        $this->getConnectionType($request->customer_id);
        $this->getCurrentBalance($request->customer_id);
        $this->reading_meter = $request->reading_meter;
        $this->computeBillConsumption($request->reading_meter);

        $surcharge = (empty($this->balance->payment_or_no)) ? ($this->balance->balance * $this->surcharge[0]->rate) : 0.00;
        $meter_consumption = $request->reading_meter - $this->balance->reading_meter;
        $total_consumption = (($meter_consumption - $this->rate['max_range']) * $this->rate['excess_rates']) + $this->rate['min_rate'];
        $amount_comsumption = $meter_consumption <= $this->rate['max_range'] ? $this->rate['min_rate'] : $total_consumption;

        $total = ($surcharge + $this->balance->balance) + ($this->balance->billing_meter_ips + $amount_comsumption);
        $date = ($this->balance->period_covered != "Beginning Balance" ? explode('-', $this->balance->period_covered) : explode('/', '/'.$this->balance->reading_date));

        $this->computed_total = [
            'surcharge' => $surcharge,
            'meter_consumption' => $meter_consumption,
            'total_consumption' => $total_consumption,
            'amount_consumption' => $amount_comsumption,
            'total' => $total,
            'date' => Carbon::parse($date[1])->format('M d').'-'.Carbon::parse($date[1])->addMonths(1)->format('M d, Y')
        ];

        return response()->json(['created' => true, 'surcharge' => $this->surcharge, 
                                'rate' => $this->rate, 'bal' => $this->balance,
                                'total' => $this->computed_total]);
    }

    public function computeBillConsumption($reading_meter)
    {
        $surcharge = (empty($this->balance->payment_or_no)) ? ($this->balance->balance * $this->surcharge[0]->rate) : 0.00;
        $meter_consumption = $reading_meter - $this->balance->reading_meter;
        $total_consumption = (($meter_consumption - $this->rate['max_range']) * $this->rate['excess_rates']) + $this->rate['min_rate'];
        $amount_comsumption = $meter_consumption <= $this->rate['max_range'] ? $this->rate['min_rate'] : $total_consumption;

        $total = ($surcharge + $this->balance->balance) + ($this->balance->billing_meter_ips + $amount_comsumption);
        $date = ($this->balance->period_covered != "Beginning Balance" ? explode('-', $this->balance->period_covered) : explode('/', '/'.$this->balance->reading_date));

        $this->computed_total = [
            'surcharge' => $surcharge,
            'meter_consumption' => $meter_consumption,
            'total_consumption' => $total_consumption,
            'amount_consumption' => $amount_comsumption,
            'total' => $total,
            'date' => Carbon::parse($date[1])->format('M d').'-'.Carbon::parse($date[1])->addMonths(1)->format('M d, Y')
        ];
    }
}