<?php namespace App\Classes\Facades;

use App\Exceptions\ExpectedKeyNotFoundException;

class CustomerDataHelper{
    

    public static function normalize(array $customerData)
    {
       
        if(!array_key_exists('firstname',$customerData) ||  
        !array_key_exists('lastname',$customerData) ||
       
        !array_key_exists('purok',$customerData))
            {
                throw new ExpectedKeyNotFoundException();
            }

     
        $customerData['firstname']=ucwords(strtolower($customerData['firstname']));
        if(isset($customerData['middlename']))
        {
            $customerData['middlename']=ucwords(strtolower($customerData['middlename']));
        }
        $customerData['lastname']=ucwords(strtolower($customerData['lastname']));
        $customerData['purok']=ucwords(strtolower($customerData['purok']));
        return $customerData;
    }


}