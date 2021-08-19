<?php namespace App\Services;

class Options{


    private $services=[
        'reconnection'=>'Reconnection',
        'transfer_of_meter'=>'Transfer of Meter',
        'change_of_meter'=>'Change of Meter',
        'transfer_of_ownership'=>'Transfer of Ownership',
        'disconnection'=>'Disconnection',
        'others'=>'Others'
    ];

    public function getServices()
    {
        return $this->services;
    }

}