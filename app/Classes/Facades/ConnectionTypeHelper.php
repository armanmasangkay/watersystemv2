<?php

namespace App\Classes\Facades;

class ConnectionTypeHelper{
    public static function toReadableString($value){
        $data = [
            'pending_building_inspection' => 'Pending for Building Inspection',
            'pending_waterworks_inspection'=>'Pending for Waterworks  Inspection',
            'pending' => 'Pending'
        ];

        return $data[$value];
    }
}
