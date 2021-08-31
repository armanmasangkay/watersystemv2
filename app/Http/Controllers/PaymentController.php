<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function getBalance($account_number)
    {
        $balance = Transaction::orderBy('created_at', 'asc')->where('customer_id', $account_number)->where('balance', '>', 0)->get();
        $balance = $balance->first();
        return Response::json(['getBalance' => true, 'acc' => $account_number, 'bal' => $balance]);
    }

    public function save_payment(Request $request, $account_number)
    {
        $validator = Validator::make($request->all(),[
            'orNum' => 'required|unique',
            'inputedAmount' => 'required|numeric|gt:0'
        ]);

        if($validator->fails()){
            return response()->json(['created' => false, 'errors' => $validator->errors()], 400);
        }


        $transaction = Transaction::where(['customer_id' =>$account_number])->get()->toArray();
        $amount = ($request->inputedAmount >= $request->totalAmount ? $request->totalAmount : $request->inputedAmount);

        for($i = 0; $i < count($transaction); $i++)
        {
            if($transaction[$i]['balance'] > 0)
            {
                $update = Transaction::findOrFail($transaction[$i]['id']);
                $update->balance -= $amount;
                $update->update();
            }
        }

        $data = [
            'or_no' => $request->orNum,
            'customer_id' => $account_number,
            'transaction_id' => $request->curr_transaction_id,
            'payment_date' => date('Y-m-d', strtotime($request->payment_date)),
            'payment_amount' => $amount,
            'balance' => ($request->totalAmount - $amount),
            'user_id' => Auth::id()
        ];
        Payments::create($data);

        return Response::json(['created' => true]);
    }
}
