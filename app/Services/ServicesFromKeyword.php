<?php namespace App\Services;

use App\Models\Service;

class ServicesFromKeyword{


    public function get($keyword, $status)
    {
        $services=Service::rightjoin('customers', 'customer_id' ,'=', 'account_number')
                            ->where('status', $status)
                            ->where('firstname',$keyword)
                            ->orWhere('lastname',$keyword)
                            ->orWhereRaw("concat(firstname,' ',lastname)=?",$keyword)
                            ->orWhereRaw("concat(lastname,' ',firstname)=?",$keyword)
                            ->orWhere('account_number','LIKE',"%{$keyword}%")
                            ->orWhere('org_name','LIKE',"%{$keyword}%")
                            ->get();

        return $services;
    }
}
