<?php namespace App\Classes\Facades;


class FakeCustomerData{


    public static function civilStatus()
    {
        $data=[
            'married',
            'single',
            'windowed'
        ];
        return $data[random_int(0,count($data)-1)];
    }

    public static function connectionType()
    {
        $connectionTypes=[
            'residential',
            'commercial',
            'institutional',
            'others'
        ];
        return $connectionTypes[random_int(0,count($connectionTypes)-1)];
    }
    public static function connectionStatus()
    {
        $connectionStatuses=[
            'active',
            'inactive',
            'others'
        ];

        return $connectionStatuses[random_int(0,count($connectionStatuses)-1)];

    }
}