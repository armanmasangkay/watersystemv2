<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Classes\Facades\StringHelper;

class Service extends Model
{
    use HasFactory;

    protected static $serviceTypes=[
        'reconnection'=>'Reconnection',
        'transfer_of_meter_different'=>'Transfer of Meter (Different Household)',
        'transfer_of_meter_same'=>'Transfer of Meter (Same Household)',
        'change_of_meter'=>'Change of Meter',
        'transfer_of_ownership'=>'Transfer of Ownership',
        'disconnection'=>'Disconnection',
        'new_connection' => 'New Connection',
        'repairs_of_damage_connection' => 'Repairs of damage connection',
        'report_of_no_water_low_pressure' => 'Report of no water, Low Pressure',
        'defective_meter_and_other_related_request' => 'Defective meter and other related request',
        'others' => 'Others'
    ];

    protected $fillable=[
        'customer_id',
        'type_of_service',
        'remarks',
        'landmarks',
        'work_schedule',
        'status',
        'start_status'
    ];

    public static $PENDING_BUILDING_INSPECTION="pending_building_inspection";
    public static $PENDING_WATERWORKS_INSPECTION="pending_waterworks_inspection";
    public static $PENDING_ENGINEER_APPROVAL="pending_engineer_approval";
    public static $READY="ready";


    public static function getServiceTypes()
    {
        return self::$serviceTypes;
    }

    public static function getInitialStatus($serviceType)
    {
        
        switch($serviceType)
        {
            case 'new_connection':
                return self::$PENDING_BUILDING_INSPECTION;
            case 'reconnection':
                return self::$PENDING_BUILDING_INSPECTION;
            case 'transfer_of_meter_different':
                return self::$PENDING_BUILDING_INSPECTION;
            case 'transfer_of_meter_same':
                return self::$PENDING_WATERWORKS_INSPECTION;
            case 'change_of_meter':
                return self::$PENDING_WATERWORKS_INSPECTION;
            case 'transfer_of_ownership':
                return self::$PENDING_ENGINEER_APPROVAL;
            case 'disconnection':
                return self::$PENDING_ENGINEER_APPROVAL;
            default:
                return self::$READY;
    
        }
    }

    // protected static function booted()
    // {
    //     static::creating(function ($service) {
    //         $service->status=$this->getInitialStatus($this->type_of_service);
    //         $service->start_status=$this->getInitialStatus($this->type_of_service);
    //     });
    // }


    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','account_number');
    }

    private function changeDateFormat($dateString)
    {
        return Carbon::createFromFormat('Y-m-d',$dateString)->format('M d, Y');
    }

    public function buildingInspectionSchedHuman()
    {
        return $this->changeDateFormat($this->building_inspection_schedule);
    }

    public function waterWorksSchedHuman()
    {
        return $this->changeDateFormat($this->water_works_schedule);
    }

    public function serviceType()
    {
        return StringHelper::toReadableService($this->type_of_service);
    }
}
