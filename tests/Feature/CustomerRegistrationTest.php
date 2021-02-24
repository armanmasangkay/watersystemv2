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
        $this->assertDatabaseHas('customers',[
            'firstname'=>'Arman',
            'lastname'=>'Masangkay'
        ]);
    }


    public function test_returns_a_json_error_list_if_required_fields_has_no_value()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $customerData=[
            'account_number'=>'',
            'firstname'=>'',
            'middlename'=>'',
            'lastname'=>'',
            'civil_status'=>'',
            'purok'=>'',
            'barangay'=>'',
            'contact_number'=>'',
            'connection_type'=>'',
            'connection_status'=>''
        ];
        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertExactJson([
           'created'=>false,
           'errors'=>[
               'account_number'=>['Account number must not be empty'],
               'firstname'=>['First name must not be empty'],
               'lastname'=>['Last name must not be empty'],
               'civil_status'=>['Civil status must not be empty'],
               'purok'=>['Purok must not be empty'],
               'barangay'=>['Barangay must not be empty'],
               'contact_number'=>['Contact number must not be empty'],
               'connection_type'=>['Connection type must not be empty'],
               'connection_status'=>['Connection Status must not be empty']
           ]
        ]);

        $this->assertDatabaseCount('customers',0);
    }

    public function test_registering_customer_can_only_be_accessed_by_admin()
    {
       $response=$this->post(route('admin.register-customer'),[
            'test'=>'test'
        ]);

        $response->assertRedirect(route('login'));
    }
}
