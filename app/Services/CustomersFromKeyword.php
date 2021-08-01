<?php namespace App\Services;

use App\Models\Customer;

class CustomersFromKeyword{
    

    public function get($keyword)
    {
        $customers=Customer::where('firstname',$keyword)
                            ->orWhere('lastname',$keyword)
                            ->orWhereRaw("concat(firstname,' ',lastname)=?",$keyword)
                            ->orWhereRaw("concat(lastname,' ',firstname)=?",$keyword)
                            ->orWhere('account_number','LIKE',"%{$keyword}%")
                            ->orWhere('org_name','LIKE',"%{$keyword}%")
                            ->get();

        return $customers;
    }
}