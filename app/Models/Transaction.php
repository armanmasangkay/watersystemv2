<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\Payments;
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
        'user_id',
        'posted_by'
    ];
    private   function toAccounting($num)
    {
        return number_format($num, 2, '.', ',');
    }

    public function paymentAmountFormatted()
    {
        return $this->toAccounting($this->payment_amount);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','account_number');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'transaction_id');
    }
}
