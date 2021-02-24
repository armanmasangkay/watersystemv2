<?php namespace App\Classes\Facades;

class AccountNumber{


    public static function new(string $barangayCode, int $numberOfPeopleRegistered)
    {
        $yearToday=date("Y");
        $zeroPaddedRegistrationId=str_pad($numberOfPeopleRegistered+1,3,"0",STR_PAD_LEFT);
        return "$barangayCode-$yearToday-$zeroPaddedRegistrationId";
    }
}