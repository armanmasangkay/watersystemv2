<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BarangayDoesNotExistException extends Exception
{
    // public function report()
    // {
    //     Log::debug('Barangay does not exist');
    // }
}
