<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=[
        'customer_id',
        'period_covered',
        'reading_date',
        'reading_meter',
        'reading_consumption',
        'billing_amount',
        'billing_surcharge',
        'billing_meter_ips',
        'billing_total',
        'payment_or_no',
        'payment_date',
        'payment_amount',
        'balance',
        'user_id'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','account_number');
    }


}
