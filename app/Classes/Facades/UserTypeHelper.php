<?php

namespace App\Classes\Facades;

class UserTypeHelper{
    public static function toReadableUserString($value){
        $data = [
            '1' =>'Administrator',
            '2' =>'Cashier',
            '3' =>'Meter Reader',
            '4' =>'Building Inspector',
            '5' =>'Waterworks Inpector',
            '6' =>'Encoder'
        ];

        return $data[$value];
    }
}