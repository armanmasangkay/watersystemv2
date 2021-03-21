<?php

namespace Tests\Feature;

use App\Classes\Facades\AccountNumber;
use App\Classes\Facades\CustomerRegistrationOptions;
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'09757375747',
            'connection_type'=>'institutional',
            'connection_status'=>'active',
            'purchase_option'=>'cash'
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertJson([
            'created'=>true
        ]);
        $this->assertDatabaseHas('customers',[
            'firstname'=>'Arman',
            'lastname'=>'Masangkay',
            'purchase_option'=>'cash',
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
            'connection_status'=>'',
            'purchase_option'=>'',
        ];
        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertSimilarJson([
           'created'=>false,
           'errors'=>[
               'firstname'=>['First name must not be empty'],
               'lastname'=>['Last name must not be empty'],
               'civil_status'=>['Civil status must not be empty'],
               'purok'=>['Purok must not be empty'],
               'barangay'=>['Barangay must not be empty'],
               'contact_number'=>['Contact number must not be empty'],
               'connection_type'=>['Connection type must not be empty'],
               'connection_status'=>['Connection Status must not be empty'],
               'purchase_option'=>['Purchase meter option must not be empty']
           ]
        ]);

        $this->assertDatabaseCount('customers',0);
    }

    public function test_registering_customer_post_request_returns_unauthorized_error_if_not_authenticated()
    {
       $response=$this->post(route('admin.register-customer'),[
            'test'=>'test'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'error'=>'Unauthorized access'
        ]);
    }

    public function test_returns_error_when_purchase_option_provided_is_invalid()
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'09757375747',
            'connection_type'=>'institutional',
            'connection_status'=>'active',
            'purchase_option'=>'invalidpurchaseoption'
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'purchase_option'=>['Invalid purchase option selected']
            ]

        ]);

        $this->assertDatabaseCount('customers',0);
      
    }

    public function test_returns_error_when_civil_status_value_is_not_valid()
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
            'civil_status'=>'not married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'09757375747',
            'connection_type'=>'institutional',
            'connection_status'=>'active',
            'purchase_option'=>'cash',
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'civil_status'=>['Invalid civil status value']
            ]

        ]);

        $this->assertDatabaseCount('customers',0);
      
    }

    public function test_returns_error_when_barangay_value_is_not_valid()
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Alien Place",
            'contact_number'=>'09757375747',
            'connection_type'=>'institutional',
            'connection_status'=>'active',
            'purchase_option'=>'cash',
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'barangay'=>['Invalid barangay value']
            ]

        ]);

        $this->assertDatabaseCount('customers',0);

    }

    public function test_customer_registration_returns_an_error_if_contact_number_contains_non_numeric_data()
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'a9757375747',
            'connection_type'=>'institutional',
            'connection_status'=>'active',
            'purchase_option'=>'cash',
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'contact_number'=>['Contact number must only contain numbers',"Contact number should be 11 digits"]
            ]

        ]);

        $this->assertDatabaseCount('customers',0);

    }

    public function test_customer_registration_returns_an_error_if_contact_number_contains_digits_lesser_than_11()
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'0975737574',
            'connection_type'=>'institutional',
            'connection_status'=>'active',
            'purchase_option'=>'cash',
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);
    
        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'contact_number'=>['Contact number should be 11 digits']
            ]

        ]);

        $this->assertDatabaseCount('customers',0);

    }

    public function test_customer_registration_get_route_can_be_accessed_only_by_admins()
    {
       $response= $this->get(route('admin.register-customer'));
        $response->assertRedirect(route('login'));
    }

    public function test_customer_registration_route_returns_registration_view()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $response=$this->actingAs($user)->get(route('admin.register-customer'));
        $response->assertViewIs('pages.customer-registration');
    }
    
    public function test_customer_registration_form_view_can_be_rendered()
    {
       $view=$this->view('pages.customer-registration',[
           'civilStatuses'=>CustomerRegistrationOptions::civilStatuses(),
           'barangays'=>CustomerRegistrationOptions::barangays(),
           'connectionTypes'=>CustomerRegistrationOptions::connectionTypes(),
           'connectionStatuses'=>CustomerRegistrationOptions::connectionStatuses()
       ]);
       $view->assertSee('Register a Customer');

    }

    public function test_selecting_connection_type_to_others_should_throw_an_error_if_connection_type_specifics_is_not_provided()
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'09757375747',
            'connection_type'=>'others',
            'connection_type_specifics'=>'',
            'connection_status'=>'active',
            'purchase_option'=>'cash',
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);

        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'connection_type_specifics'=>['Specific connection type must be provided if "OTHERS" is selected']
            ]
        ]);

        $this->assertDatabaseCount('customers',0);
    }

    public function test_selecting_connection_status_to_others_should_throw_an_error_if_connection_status_specifics_is_not_provided()
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
            'civil_status'=>'married',
            'purok'=>'Purok 1',
            'barangay'=>"Amparo",
            'contact_number'=>'09757375747',
            'connection_type'=>'institutional',
            'connection_type_specifics'=>'',
            'connection_status'=>'others',
            'connection_status_specifics'=>'',
            'purchase_option'=>'cash',
        ];

        $response=$this->actingAs($user)->post(route('admin.register-customer'),$customerData);

        $response->assertExactJson([
            'created'=>false,
            'errors'=>[
                'connection_status_specifics'=>['Specific connection status must be provided if "OTHERS" is selected']
            ]
        ]);

        $this->assertDatabaseCount('customers',0);
    }

}
