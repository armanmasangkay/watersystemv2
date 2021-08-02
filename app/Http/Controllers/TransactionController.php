<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.new-transact', ['route' => 'admin.search-customer']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'contact_number' => 'required|numeric',
            'building_inspection_schedule' => 'required|date|after_or_equal:'.now()->format('Y-m-d'),
            'water_works_schedule' => 'required|date|after_or_equal:'.now()->format('Y-m-d')
        ]);


        if($validator->fails()){
            return redirect(route('admin.search-customer',[
                'account_number'=>$request->customer_id
            ]))->withErrors($validator)->with([
                'remarks' => $request->remarks,
                'landmarks' => $request->landmarks,
                'contact_number' => $request->contact_number,
                'building_inspection_schedule' => $request->building_inspection_schedule,
                'water_works_schedule' => $request->water_works_schedule,
            ]);
        }

        Transaction::create($request->all());

        return redirect(route('admin.transactions.create'))->with([
            'created'=>true,
            'message'=>'Successfully created a new transaction.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function edit($account_id, $id)
    {
        // $this->getLastTransaction($account_id, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
