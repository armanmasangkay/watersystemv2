<?php
namespace App\Services;


class ServiceReturnDataArray{


    public static function set($service_value, $data_value){
        $data = [
            'pending_building_inspection' => ['search_route' => 'admin.search','route' => 'admin.undo', 'text' => ['Lists of Request for Building/Area Inspections', 'View Approved Request'], 'search_heading' => 'SEARCH REQUEST','services' => $data_value],
            'denied_building_inspection' =>['search_route' => 'admin.search.denied','route' => 'admin.request-approvals', 'text' => ['Lists of Denied Request for Building/Area Inspections', 'Return Back'], 'search_heading' => 'SEARCH REQUEST','services' => $data_value],
            'pending_waterworks_inspection' => ['search_route' => 'admin.water.search','route' => 'admin.waterworks-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'services' => $data_value]
        ];
        return $data[$service_value];
    }
}
