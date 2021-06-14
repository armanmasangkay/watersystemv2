<?php namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class AccountNumberService{
    

    public function getNumberOfCustomersPadded()
    {
        return Str::padLeft(Customer::all()->count()+1,4,'0');
    }


    public function generateNew($brgyCode,$purokCode)
    {
        $now = Carbon::now();
        return "{$brgyCode}{$purokCode}-{$now->year}-{$this->getNumberOfCustomersPadded()}";
    }
}