<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'connection_status'
    ];

    public function fullname()
    {
        return "{$this->firstname} {$this->lastname}";
    }
    public function address()
    {
        return "{$this->purok}, {$this->barangay}";
    }

    public function connectionType()
    {
        return Str::title($this->connection_type);
    }

    
}
