<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\Transaction;

class Payments extends Model
{
    use HasFactory;

    protected $fillable=[
        'customer_id',
        'transaction_id',
        'or_no',
        'payment_date',
        'payment_amount',
        'balance',
        'user_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'id','transaction_id');
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
