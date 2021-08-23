<?php

namespace App\Classes\Facades;

class ConnectionTypeHelper{
    public static function toReadableString($value){
        $data = [
            'new_connection' => 'New Connection',
            'reconnection'=>'Reconnection',
            'transfer_of_meter'=>'Transfer of Meter',
            'change_of_meter'=>'Change of Meter',
            'transfer_of_ownership'=>'Transfer of Ownership',
            'disconnection'=>'Disconnection',
            'others'=>'Others'
        ];

        return $data[$value];
    }
}
