<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class EditBillingController extends Controller
{
    public $waterbill;

    public function __construct()
    {
        $this->waterbill = new WaterBill();
    }
    
    public function getBill(Request $request, $transaction_id)
    {
        $prev_meter = 0;
        $prev_bal = 0;
        $balance = Transaction::where('id', $transaction_id)->get();
        $prev = Transaction::orderByDesc('id')->where('id','<', $transaction_id)->get();
        $prev = $prev->first();

        $prev_meter = $prev!= null ? $prev->reading_meter : 0;
        $prev_bal = $prev!= null ? $prev->balance : 0.00;

        $nxt_trans_update = Transaction::orderBy('created_at', 'asc')->where(['customer_id' => $request->edit_customer_id])->where('id', '>', $transaction_id)->get();
        $nxt_trans_update = $nxt_trans_update->first();

        return Response::json(['getBill' => true, 'acc' => $request->edit_customer_id, 'bal' => $balance, 'meter' => $prev_meter, 'balance' => $prev_bal, 'nxt_mtr' => !empty($nxt_trans_update->reading_meter) ? $nxt_trans_update->reading_meter : 0]);
    }

    public function updateBill(Request $request)
    {
        if($request->current_meter < $request->edit_meter_reading_bal)
        {
            return response()->json(['created' => false, 'msg' => 'Current meter reading should not be less than the previous meter reading.']);
        }

        $prv_trans_update = Transaction::orderByDesc('created_at')->where(['customer_id' => $request->edit_customer_id])->where('id', '<', $request->edit_curr_transaction_id)->get();
        $prv_trans_update = $prv_trans_update->first();

        $amount_bal = $prv_trans_update != null ? $prv_trans_update->balance : 0.00;
        $amount_total = $prv_trans_update != null ? $prv_trans_update->billing_total : 0.00;

        $reading_meter = 0;
        $update_transaction = Transaction::findOrFail($request->edit_curr_transaction_id);

        $update_transaction->billing_surcharge = ($request->edit_meter_reading < $request->current_meter) ? 
                                                (($amount_bal + $request->edit_amount) * $this->waterbill->surcharge[0]->rate) : 
                                                (($amount_bal - $request->edit_amount) * $this->waterbill->surcharge[0]->rate);

        $update_transaction->billing_total = ($request->edit_meter_reading < $request->current_meter) ? 
                                            ($amount_total + $request->edit_amount) + (($amount_total + $request->edit_amount) * $this->waterbill->surcharge[0]->rate) : 
                                            ($amount_total - $request->edit_amount) + (($amount_total - $request->edit_amount) * $this->waterbill->surcharge[0]->rate);

        $update_transaction->balance = ($request->edit_meter_reading < $request->current_meter) ? 
                                        (($amount_bal + $request->edit_amount)) + (($amount_bal + $request->edit_amount) * $this->waterbill->surcharge[0]->rate) : 
                                        (($amount_bal - $request->edit_amount)) + (($amount_bal - $request->edit_amount) * $this->waterbill->surcharge[0]->rate); 

        $update_transaction->billing_amount = $request->edit_amount;
        $update_transaction->reading_consumption = $request->edit_consumption;
        $update_transaction->reading_meter = $request->edit_reading_meter;
        $update_transaction->reading_date = date('Y-m-d', strtotime($request->edit_reading_date));
        $update_transaction->update();

        $reading_amount = $reading_meter * $request->edit_excess_rate;

        $nxt_trans_update = Transaction::orderBy('id', 'asc')->where(['customer_id' => $request->edit_customer_id])->where('id', '>', $request->edit_curr_transaction_id)->get()->toArray();
        
        if($nxt_trans_update != null)
        {
            for($i = 0; $i < count($nxt_trans_update); $i++)
            {
                $this->waterbill->getConnectionType($nxt_trans_update[$i]['customer_id']);
                $prv_trans = Transaction::orderBy('id','desc')->where(['customer_id' => $request->edit_customer_id])->where('id', '<', $nxt_trans_update[$i]['id'])->get();
                $prv_trans = $prv_trans->first();

                $reading_meter = ($request->edit_reading_meter >= $request->current_meter) ? ($request->edit_reading_meter - $request->current_meter) : ($request->current_meter - $request->edit_reading_meter);
                $update = Transaction::find($nxt_trans_update[$i]['id']);

                $consumption = ($nxt_trans_update[$i]['reading_meter'] >= $request->edit_reading_meter) ? ($nxt_trans_update[$i]['reading_meter'] - $request->edit_reading_meter) : 0;

                $billing_amount = ($request->edit_reading_meter <= $request->current_meter) ? ($nxt_trans_update[$i]['billing_amount'] + $reading_amount) :
                                ($nxt_trans_update[$i]['billing_amount'] - $reading_amount);

                
                $amount = ($consumption > $this->waterbill->rate['max_range']) ? 
                        ($this->waterbill->rate['min_rate'] + (($consumption - $this->waterbill->rate['max_range']) * ($this->waterbill->rate['excess_rates']))) : 
                        $this->waterbill->rate['min_rate'];

                $surcharge = (($amount + $prv_trans->balance) * $this->waterbill->surcharge[0]->rate);
                $balance = ($amount + $prv_trans->balance) + $surcharge;
                $bill_total = ($amount + $prv_trans->billing_total) + $surcharge;

                $update->balance = $balance >= 0 ? $balance : 0;
                $update->billing_total = $bill_total >= 0 ? $bill_total : 0;
                $update->billing_surcharge = $nxt_trans_update[$i]['billing_surcharge'] > 0 ? $surcharge : 0;
                $update->billing_amount = $amount >= 0 ? $amount : 0;
                $update->reading_consumption = ($consumption >= 0 ? $consumption : 0);
                $update->update();
            }
        }

        return Response::json(['created' => true, 'data' => $request->edit_customer_id]);
    }
}
