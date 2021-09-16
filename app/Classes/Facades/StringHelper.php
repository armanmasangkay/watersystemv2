<?php

namespace App\Classes\Facades;

use App\Models\Service;

class StringHelper
{

    public static function toReadableStatus($value){
        $data = Service::getServiceStatus();

        return $data[$value];
    }

    public static function toReadableService($value){
        $data = Service::getServiceTypes();

        return $data[$value];
    }
}
