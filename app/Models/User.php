<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaction;
use App\Classes\Facades\UserTypeHelper;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public static $ADMIN=1;
    public static $CASHIER=2;
    public static $READER=3;
    public static $BLDG_INSPECTOR=4;
    public static $WATERWORKS_INSPECTOR=5;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
       'username',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function validRoles()
    {
        return [
            '1'=>'Admin',
            '2'=>'Cashier',
            '3'=>'Meter Reader',
            '4'=>'Building Inspector',
            '5'=>'Waterworks Inspector',
            '6'=>'Municipal Engineer'
        ];
    }

    public static function defaultPassword()
    {
        return '12345678';
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function isCashier()
    {
        return $this->role==2;
    }

    public function isReader()
    {
        return $this->role==3;
    }

    public function isAdmin()
    {
        return $this->role==1;
    }

    public function isBuildingInspector()
    {
        return $this->role==4;
    }

    public function isWaterworksInspector()
    {
        return $this->role==5;
    }

    public function username()
    {
        return $this->username;
    }

    public function name()
    {
        return $this->name;
    }

    public function user_role()
    {
        return UserTypeHelper::toReadableUserString($this->role);
    }
}
