<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer_organization_name',
        'customer_firstname',
        'customer_middlename',
        'customer_lastname',
        'type_of_transaction',
        'issued_by'
    ];
}
