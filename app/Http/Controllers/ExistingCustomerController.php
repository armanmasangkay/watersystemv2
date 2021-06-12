<?php

namespace App\Http\Controllers;

use App\Classes\Facades\AccountNumber;
use App\Classes\Facades\BarangayData;
use App\Classes\Facades\CustomerDataHelper;
use App\Classes\Facades\CustomerRegistrationOptions;
use App\Models\Customer;
use App\Models\Transaction;
use App\Services\AccountNumberService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExistingCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('pages.consumer-data-entry',[
            'civilStatuses'=>CustomerRegistrationOptions::civilStatuses(),
            'barangays'=>CustomerRegistrationOptions::barangays(),
            'connectionTypes'=>CustomerRegistrationOptions::connectionTypes(),
            'connectionStatuses'=>CustomerRegistrationOptions::connectionStatuses()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
