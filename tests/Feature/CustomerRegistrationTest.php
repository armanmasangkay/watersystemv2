<?php

namespace Tests\Feature;

use App\Classes\Facades\AccountNumber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_register_a_customer_with_valid_data()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $customerData=[
            'account_number'=>AccountNumber::new("020",0),
            'firstname'=>'Arman',
            'middlename'=>'Macasuhot',
            'lastname'=>'Masangkay',
            'civil_status'=>'Married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'09757375747',
            'connection_type'=>'institutional',
            'connection_status'=>'active'
        ];
        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertJson([
            'created'=>true
        ]);
    }
}
