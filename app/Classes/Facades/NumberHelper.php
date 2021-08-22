<?php

namespace App\Classes\Facades;

class NumberHelper{

    public static  function toAccounting($num)
    {
        return number_format($num, 2, '.', ',');
    }

    public static function orNumbers($or) { return $or."/"; }
}
