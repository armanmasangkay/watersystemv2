<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class EditBillingController extends Controller
{
    public function getBill(Request $request, $transaction_id)
    {
        $prev_meter = 0;
        $prev_bal = 0;
        $balance = Transaction::where('id', $transaction_id)->get();
        $prev = Transaction::where('id', ($transaction_id - 1))->get();
        foreach($prev as $prev_trans)
        {
            $prev_meter = $prev_trans->reading_meter;
            $prev_bal = $prev_trans->balance;
        }

        $nxt_trans_update = Transaction::orderBy('created_at', 'asc')->where(['customer_id' => $request->customer_id])->where('id', '>', $transaction_id)->get();
        $nxt_trans_update = $nxt_trans_update->first();

        return Response::json(['getBill' => true, 'acc' => $request->customer_id, 'bal' => $balance, 'meter' => $prev_meter, 'balance' => $prev_bal, 'nxt_mtr' => !empty($nxt_trans_update->reading_meter) ? $nxt_trans_update->reading_meter : 0]);
    }

    public function updateBill(Request $request, $transaction_id)
    {
        $reading_meter = 0;
        $update_transaction = Transaction::find($request->edit_curr_transaction_id);

        $update_transaction->billing_surcharge = ($request->edit_meter_reading >= $request->current_meter) ? ($update_transaction->billing_surcharge + ($request->edit_surcharge_amount - $update_transaction->billing_surcharge)) : 
                                                    ($update_transaction->billing_surcharge - ($update_transaction->billing_surcharge - $request->edit_surcharge_amount));
        $update_transaction->billing_total = ($request->edit_meter_reading >= $request->current_meter) ? ($request->billing_total + ($request->billing_total - $request->edit_total)) :
                                                ($request->billing_total - ($request->billing_total - $request->edit_total));
        $update_transaction->balance = ($request->edit_meter_reading >= $request->current_meter) ? ($request->billing_total + ($request->billing_total - $request->edit_total)) : 
                                        ($request->billing_total - ($request->billing_total - $request->edit_total));
        $update_transaction->billing_amount = $request->edit_amount;
        $update_transaction->reading_consumption = $request->edit_consumption;
        $update_transaction->reading_meter = $request->edit_reading_meter;
        $update_transaction->reading_date = date('Y-m-d', strtotime($request->edit_reading_date));
        $update_transaction->update();
        
        $reading_amount = $reading_meter * $request->edit_excess_rate;

        $nxt_trans_update = Transaction::where(['customer_id' => $request->edit_customer_id])->where('id', '>', $request->edit_curr_transaction_id)->get()->toArray();

        for($i = 0; $i < count($nxt_trans_update); $i++)
        {
            $reading_meter = ($request->edit_reading_meter >= $request->current_meter) ? ($request->edit_reading_meter - $request->current_meter) : ($request->current_meter - $request->edit_reading_meter);
            $update = Transaction::find($nxt_trans_update[$i]['id']);
            
            $consumption = ($request->edit_reading_meter <= $request->current_meter) ? ($nxt_trans_update[$i]['reading_consumption'] + $reading_meter) : 
                            ($nxt_trans_update[$i]['reading_consumption'] - $reading_meter);
            $billing_amount = ($request->edit_reading_meter <= $request->current_meter) ? ($nxt_trans_update[$i]['billing_amount'] + $reading_amount) : 
                            ($nxt_trans_update[$i]['billing_amount'] - $reading_amount);

            $amount = ($billing_amount + $request->edit_total);
            $surcharge = ($amount * $request->edit_surcharge);

            $update->balance = ($request->edit_reading_meter <= $request->current_meter) ? ($nxt_trans_update[$i]['billing_total'] + $reading_amount) : 
                                ($nxt_trans_update[$i]['billing_total'] - $reading_amount);
            $update->billing_total = ($request->edit_reading_meter <= $request->current_meter) ? ($nxt_trans_update[$i]['billing_total'] + $reading_amount) : 
                                        ($nxt_trans_update[$i]['billing_total'] - $reading_amount);  
            $update->billing_surcharge = ($nxt_trans_update[$i]['billing_surcharge'] > 0 ? $surcharge : 0);
            $update->billing_amount = ($nxt_trans_update[$i]['billing_amount'] > $request->edit_min_rates ? $billing_amount : $request->edit_min_rates);
            $update->reading_consumption = $consumption;
            $update->update();
        }
        
        return Response::json(['created' => true/*, 'data' => ($a)*/]);
    }
}
