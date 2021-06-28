<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SearchedCustomerController extends Controller
{
   
    public function index(SearchCustomerRequest $request)
    {
        $customers=Customer::where('firstname',$request->keyword)
                            ->orWhere('lastname',$request->keyword)
                            ->orWhereRaw("concat(firstname,' ',lastname)=?",$request->keyword)
                            ->orWhereRaw("concat(lastname,' ',firstname)=?",$request->keyword)
                            ->orWhere('account_number','LIKE',"%{$request->keyword}%")
                            ->orWhere('org_name','LIKE',"%{$request->keyword}%")
                            ->get();
                            
        $customers=new Paginator($customers->all(),10);
                
        return view('pages.customers-list',[
                            'customers'=>$customers,
                            'keyword'=>$request->keyword
                    ]);
    }

   
}
