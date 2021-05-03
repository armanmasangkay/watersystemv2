<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Transaction;
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
        'purchase_option'
    ];


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

    public function connectionType()
    {
        return Str::title($this->connection_type);
    }

    public function purchaseOption()
    {
        return Str::title($this->purchase_option);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function hasActiveConnection()
    {
        return $this->connection_status==="active";
    }
}
