<?php
namespace App\Services;


class ServiceReturnDataArray{


    public static function set($serviceStatus, $services)
    {
        $data = [
            'pending_building_inspection' => [
                'search_route' => 'admin.search',
                'index_route' => 'admin.request-approvals',
                'text' => ['Lists of Request for Building/Area Inspections','View Approved Request'],
                'services' => $services
            ],
            'pending_waterworks_inspection' => [
                'search_route' => 'admin.water.search',
                'index_route' => 'admin.waterworks-request-approvals',
                'services' => $services
            ],
            'pending_engineer_approval' => [
                'search_route' => 'admin.municipal-engineer.search',
                'index_route'=>'admin.municipal-engineer.index',
                'services' => $services,
            ]
        ];
        
        return $data[$serviceStatus];
    }
}
