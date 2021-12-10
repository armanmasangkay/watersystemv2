<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConsumerSignupController extends Controller
{
    public function signUpPage()
    {
        return view('consumer-portal.signup');
    }

    public function signUp(Request $request)
    {
        $messages=[
            'account_number.exists'=>'The inputted account number is invalid.',
            'other_party_name.required_if'=>'This field is required since you are registering in behalf of someone.',
            'account_number.unique'=>'This account number was already registered by a different account!'
        ];

        $data=$request->validate([
            'account_number'=>['required','exists:customers,account_number','unique:accounts,account_number'],
            'email'=>['required','email'],
            'mobile_number'=>['required'],
            'password'=>['required','confirmed'],
            'password_confirmation'=>['required'],
            'valid_id'=>['required','image'],
            'latest_bill'=>['required','image'],
            'other_party_name'=>['required_if:is_in_behalf,on']
        ],$messages);
       
        Account::create([
            "account_number"=>$data["account_number"],
            "email"=>$data["email"],
            "mobile_number"=>$data["mobile_number"],
            "password"=>Hash::make($data["password"]),
            "valid_id"=>$request->file("valid_id")->store("accounts/valid_ids"),
            "latest_bill"=>$request->file("latest_bill")->store("accounts/latest_bills"),
            "other_party"=>$request->is_in_behalf=="on"?$data["other_party_name"]:null,
            "status"=>Account::STATUS_PENDING
        ]);

        return back()->with([
            'created'=>true,
            'message'=>"Your registration was submitted successfully! Please wait for a confirmation from your email or through your contact number for the status of your registration. Thank you!"
        ]);
        
        
    }
}
