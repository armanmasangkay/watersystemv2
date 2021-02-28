<?php namespace App\Classes\Facades;

class CustomerRegistrationOptions{

    private static $civilStatus=[
        'married',
        'widowed',
        'single'
    ];

    private static $connectionTypes=[
        'residential',
        'commercial',
        'institutional',
        'others'
    ];

    private static $connectionStatuses=[
        'active',
        'inactive',
        'others'
    ];

    public static function civilStatuses()
    {
        return CustomerRegistrationOptions::$civilStatus;
    }

    public static function barangays()
    {
        return BarangayData::names();
    }

    public static function connectionTypes()
    {
        return self::$connectionTypes;
    }

    public static function connectionStatuses()
    {
        return self::$connectionStatuses;
    }
}