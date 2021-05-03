<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;

class BLDGApprovalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'mto_approved')->paginate(20);
        return view('pages.bldg-request-approval', ['route' => 'admin.request-approvals', 'search_heading' => 'SEARCH REQUEST','transactions' => $transactions]);
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
        $transaction->status = "bldg_approved";
        $transaction->save();

        return redirect(route('admin.request-approvals'));
    }

    public function reject($id)
    {
        $transaction = Transaction::find($id);
        $transaction->building_inspection_schedule = now()->format('Y-m-d');
        $transaction->status = "bldg_rejected";
        $transaction->save();

        return redirect(route('admin.request-approvals'));
    }
}
