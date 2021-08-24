<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Payments;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey="account_number";
    public $incrementing=false;
    protected $fillable=[
        'account_number',
        'firstname',
        'middlename',
        'lastname',
        'civil_status',
        'purok',
        'barangay',
        'contact_number',
        'connection_type',
        'connection_status',
        'purchase_option',
        'org_name'
    ];

    public function isOrgAccount()
    {
        return $this->org_name?true:false;
    }

    public function civilStatus()
    {
        return Str::title($this->civil_status);
    }

    public function fullname()
    {
        $firstname=Str::title($this->firstname);
        $lastname=Str::title($this->lastname);
        return "{$firstname} {$lastname}";
    }
    public function address()
    {
        return "{$this->purok}, {$this->barangay}";
    }
    public function account()
    {
        return "{$this->account_number}";
    }

    public function connectionType()
    {
        return Str::title($this->connection_type);
    }

    public function purchaseOption()
    {
        return Str::title($this->purchase_option);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'transaction_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id')->orderByDesc('created_at');
    }

    public function balance()
    {
        return $this->hasMany(Transaction::class, 'customer_id')->orderByDesc('created_at')->first();
    }

    public function hasActiveConnection()
    {
        return $this->connection_status==="active";
    }
}
