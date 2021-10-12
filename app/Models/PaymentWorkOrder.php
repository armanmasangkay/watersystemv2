<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\Service;

class PaymentWorkOrder extends Model
{
    use HasFactory;

    protected $fillable=[
        'service_id',
        'customer_id',
        'or_no',
        'payment_amount',
        'payment_date',
        'remarks',
        'user_id',
    ];

    public function prettyPaymentAmount()
    {
        return "P".number_format($this->payment_amount,2,".",",");
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','account_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
