<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Services\Options;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
  



    private function getServices()
    {
        return (new Options)->getServices();
    }


    public function index()
    {
        
    }

    public function search(Request $request)
    {

     
        try{
            $customer= Customer::findOrFail($request->account_number);
            return view('pages.add-service', [
                'route' => 'admin.search-customer',
                'services'=>$this->getServices(),
                'customer'=>$customer
            ]);
        }catch(ModelNotFoundException $e){
            return redirect(route('admin.services.create'))->withErrors([
                    'account_number'=>'Account number not found!'
                ])->withInput();
        }
      
    }


    public function create()
    { 

        //TODO : Show search for account number note when haven't search for an account number yet
        return view('pages.add-service', [
            'route' => 'admin.search-customer',
            'services'=>$this->getServices()
        ]);
    }


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

        Service::create($request->all());

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
    public function edit($id)
    {
        //
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
