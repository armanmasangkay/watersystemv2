<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'position'
    ];

    protected static $positions =
    [
        'internal_auditor_i' => 'Internal Auditor I'
    ];


    public static $INTERNAL_AUDITOR_I = 'internal_auditor_i';


    public static function getPositions()
    {
        return self::$positions;
    }

    public static function isValidPosition($position)
    {
        return array_key_exists($position, self::$positions);
    }

    public function prettyPosition()
    {
        return self::$positions[$this->position];
    }
}
