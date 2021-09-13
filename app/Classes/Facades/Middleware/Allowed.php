<?php namespace App\Classes\Facades\Middleware;

class Allowed{

    public static function role(...$roles)
    {
        $result="allowed:";

        foreach($roles as $role)
        {
            $result.=$role.",";
        }

        return substr($result,0,strlen($result)-1); //removes the extra ',' before returning it
    }
}