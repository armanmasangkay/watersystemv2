<?php

namespace App\Http\Requests;

use App\Services\AccountNumberService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewConnectionRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $accountNumber=(new AccountNumberService)->generateNew($this->barangayCode,$this->purokCode);
        $this->merge([
            'account_number' => $accountNumber,
        ]);
    }

    public function messages()
    {
        return [
            'account_number.required'=>'Account number must not be empty',
            'firstname.required'=>'First name must not be empty',
            'lastname.required'=>'Last name must not be empty',

            //Civil status validation
            'civil_status.required'=>'Civil status must not be empty',
            'civil_status.in'=>'Invalid civil status value',

            'purok.required'=>'Purok must not be empty',

            //Barangay validation
            'barangay.required'=>'Barangay must not be empty',
            'barangay.in'=>'Invalid barangay value',


            //Contact number validation
            'contact_number.required'=>'Contact number must not be empty',
            'contact_number.numeric'=>'Contact number must only contain numbers',
            'contact_number.digits'=>'Contact number should be 11 digits',


            'connection_type.required'=>'Connection type must not be empty',
            'connection_type_specifics.required_if'=>'Specific connection type must be provided if "OTHERS" is selected',

            'connection_status.required'=>'Connection Status must not be empty',
            'connection_status_specifics.required_if'=>'Specific connection status must be provided if "OTHERS" is selected',

        ];


    }

    protected function failedValidation($validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([ 'created'=>false,'errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
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
            'civil_status'=>'required|in:married,single,widowed',
            'purok'=>'required',
            'barangay'=>[
                'required',
            ],
            'contact_number'=>'required|numeric|digits:11',
            'connection_type'=>'required',
            'connection_type_specifics'=>'required_if:connection_type,others',

            'connection_status'=>'required',
            'connection_status_specifics'=>'required_if:connection_status,others',
            'purchase_option'=>'required|in:cash,installment,N/A',
        ];
    }
}
