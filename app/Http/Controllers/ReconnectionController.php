<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Rules\NoActiveConnection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReconnectionController extends Controller
{
    public function index()
    {
        return view('pages.reconnection', ['route' => 'admin.search']);
    }

    public function storeTransaction(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'contact_number' => 'required|numeric',
            'building_inspection_sched' => 'required|date|after_or_equal:'.now()->format('Y-m-d'),
            'waterworks_inspection_sched' => 'required|date|after_or_equal:'.now()->format('Y-m-d')
        ]);

        if($validator->fails()){
            
            return back()->withInput()->withErrors($validator);
        }

         Transaction::create([
            'customer_id'=>$request->customer_id,
            'type_of_service'=>'reconnection',
            'remarks'=>$request->remarks,
            'landmarks'=>$request->landmark,
            'contact_number'=>$request->contact_number,
            'building_inspection_schedule'=>$request->building_inspection_sched,
            'water_works_schedule'=>$request->waterworks_inspection_sched,
            'status'=>'mto_approval'
        ]);

        return back()->with([
            'status'=>'success',
            'message'=>'Reconnection transaction was created successfully!'
        ]);

    }

    public function search(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'account_number'=>['bail','required','exists:customers,account_number',new NoActiveConnection],
        ],[
           'account_number.exists'=>'Account number not found' 
        ]);

        if($validator->fails()){
            return redirect(route('admin.reconnection'))->withErrors($validator)->withInput();
        }
        $customer=Customer::find($request->account_number);

    
        return view('pages.reconnection',[
            'customer'=>$customer,
            'route' => 'admin.search'
        ]);

    }
}
