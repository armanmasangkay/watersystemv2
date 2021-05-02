<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=[
        'customer_id',
        'type_of_service',
        'remarks',
        'landmarks',
        'contact_number',
        'building_inspection_schedule',
        'water_works_schedule',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','account_number');
    }

}
