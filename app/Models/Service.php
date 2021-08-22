<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Service extends Model
{
    use HasFactory;


    protected $fillable=[
        'customer_id',
        'type_of_service',
        'remarks',
        'landmarks',
        'work_schedule',
        'status'
    ];


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
}
