<?php

namespace App\Classes\Facades;

class StringHelper{
    public static function toReadableStatus($value){
        $data = [
            'pending_building_inspection' => 'Pending for Building Inspection',
            'pending_waterworks_inspection'=>'Pending for Waterworks  Inspection',
            'pending' => 'Pending'
        ];

        return $data[$value];
    }

    public static function toReadableService($value){
        $data = [
            'new_connection' => 'New Connection',
            'reconnection' => 'Reconnection',
            'request_for_transfer_of_meter' => 'Request for transfer of meter',
            'change_of_meter' => 'Change of meter',
            'change_of_ownership' => 'Change of ownership',
            'disconnection' => 'Disconnection',
            'repairs_of_damage_connection' => 'Repairs of damage connection',
            'report_of_no_water_low_pressure' => 'Report of no water, Low Pressure',
            'defective_meter_and_other_related_request' => 'Defective meter and other related request',
            'others' => 'Others'
        ];

        return $data[$value];
    }
}
