<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=[
        'customer_id',
        'type_of_service',
        'remarks',
        'landmarks',
        'contact_number',
        'initial_building_inspection_schedule',
        'initial_water_works_schedule'
    ];
}
