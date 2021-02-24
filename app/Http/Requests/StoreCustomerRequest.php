<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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

    public function messages()
    {
        return [
            'account_number.required'=>'Account number must not be empty',
            'firstname.required'=>'First name must not be empty',
            'lastname.required'=>'Last name must not be empty',
            'civil_status.required'=>'Civil status must not be empty',
            'purok.required'=>'Purok must not be empty',
            'barangay.required'=>'Barangay must not be empty',
            'contact_number.required'=>'Contact number must not be empty',
            'connection_type.required'=>'Connection type must not be empty',
            'connection_status.required'=>'Connection Status must not be empty'

        ];
    
        
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
            'firstname'=>'required',
            'lastname'=>'required',
            'civil_status'=>'required',
            'purok'=>'required',
            'barangay'=>'required',
            'contact_number'=>'required',
            'connection_type'=>'required',
            'connection_status'=>'required'
        ];
    }
}
