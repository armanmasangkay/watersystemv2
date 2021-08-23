<?php

namespace App\Rules;

use App\Models\Service;
use Illuminate\Contracts\Validation\Rule;

class RedundantService implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $noOfServices=Service::where('type_of_service',$value)
                ->where('status','pending')->get()->count();
        $hasPendingService=$noOfServices>0;
        return !$hasPendingService;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'An existing service with this type is still not cleared yet. Adding this type of service again is not possible!';
    }
}
