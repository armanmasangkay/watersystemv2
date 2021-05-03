<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;

class WaterWorksApprovalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'bldg_approved')->paginate(20);
        return view('pages.waterworks-request-approval', ['route' => 'admin.waterworks-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'transactions' => $transactions]);
    }

    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'building_inspection_schedule'=> 'required|date|after_or_equal:'.now()->format('Y-m-d')
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $transaction = Transaction::find($request->id);
        $transaction->building_inspection_schedule = $request->building_inspection_schedule;
        $transaction->status = "waterworks_approved";
        $transaction->save();

        return redirect(route('admin.waterworks-request-approvals'));
    }

    public function reject($id)
    {
        $transaction = Transaction::find($id);
        $transaction->building_inspection_schedule = now()->format('Y-m-d');
        $transaction->status = "waterworks_rejected";
        $transaction->save();

        return redirect(route('admin.waterworks-request-approvals'));
    }
}
