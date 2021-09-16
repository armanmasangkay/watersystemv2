<?php

namespace App\Http\Requests\services;

use App\Rules\RedundantService;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_number'=>'required',
            'service_type'=>['required',new RedundantService],
            'remarks'=>'required_if:service_type,others',
            'service_schedule'=>'required|date|after_or_equal:today'
        ];
    }

    public function messages()
    {
       return [
            'remarks.required_if'=>"Remarks field is required if 'Other' is selected on Service Type field"
       ];
    }
}
