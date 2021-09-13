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
        'user_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class,'id','service_id');
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
