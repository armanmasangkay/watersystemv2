<?php

namespace Tests\Feature;

use App\Models\User;
use App\Classes\Facades\CustomerRegistrationOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;


    public function test_redirect_to_customers_registration(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.existing-customers.create'));

        $response->assertViewIs('pages.consumer-data-entry');
        $response->assertViewHasAll([
            'civilStatuses'=>CustomerRegistrationOptions::civilStatuses(),
            'barangays'=>CustomerRegistrationOptions::barangays(),
            'connectionTypes'=>CustomerRegistrationOptions::connectionTypes(),
            'connectionStatuses'=>CustomerRegistrationOptions::connectionStatuses()
        ]);
    }



    public function test_organization_name_is_saved_if_field_is_not_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'org_name'=>'SLSU',
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseHas('customers',['org_name'=>'SLSU']);
        $response->assertJson(['created'=> true]);

    }

    public function test_should_error_if_conn_type_is_others_but_have_not_specified_anything()
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'org_name'=>'',
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'others',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> false]);
        $response->assertJsonValidationErrors(['connection_type_specifics']);
    }

    public function test_should_not_produce_error_if_conn_type_is_others_but_have__specified_something()
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'org_name'=>'',
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'others',
            'connection_type_specifics'=>'some type',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> true]);
        $response->assertJsonMissingValidationErrors(['connection_type_specifics']);
    }


    public function test_should_error_if_conn_status_is_others_but_have_not_specified_anything()
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'org_name'=>'',
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'others',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> false]);
        $response->assertJsonValidationErrors(['connection_status_specifics']);
    }

    public function test_should_not_produce_error_if_conn_status_is_others_but_have__specified_something()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'org_name'=>'',
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'others',
            'connection_type_specifics'=>'some type',
            'connection_status' => 'others',
            'connection_status_specifics' => 'some status',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> true]);
        $response->assertJsonMissingValidationErrors(['connection_types_status']);
    }

    public function test_should_not_fail_even_if_org_name_is_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'org_name'=>'',
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
        $this->assertDatabaseCount('customers', 1);
        $response->assertJson(['created'=> true]);

    }



    public function test_route_cannot_be_accessed_if_user_is_not_logged_in(){
        $response = $this->get(route('admin.existing-customers.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_fail_to_register_if_customer_with_incomplete_data(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.register-customer.store'),[
        'firstname' => "June Vic",
        'middlename' => "",
        'lastname' => "Cadayona",
        'civil_status' => "Single",
        'purok' => "Somewhere",
        'barangay' => "Somewhere",
        'contact_number' => '09178781045',
        'connection_type' => "Residential",
        'connection_status' => "Active",
        'purchase_option' => "Cash",
        ]);

        $this->assertDatabaseCount('customers', 0);
        $response->assertJson(['created' => false]);
    }

    public function test_fail_to_register_if_date_is_beyond_today(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $date = Carbon::now();
        $daysToAdd = 5;
        $date = $date->addDays($daysToAdd);

        $response = $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $this->assertDatabaseCount('customers', 0);
        $response->assertJson(['created'=> false]);
    }

    public function test_success_registeration_if_customer_with_complete_and_valid_data(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $this->assertDatabaseCount('customers', 1);
        $response->assertJson(['created'=> true]);
    }

    public function test_previous_meter_reading_should_not_accept_negative_numbers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '-1',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> false]);
        $response->assertJsonValidationErrors(['reading_meter']);
    }

    public function test_balance_should_not_accept_negative_numbers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '0',
            'balance' => '-100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> false]);
        $response->assertJsonValidationErrors(['balance']);
    }

    public function test_meter_IPS_should_not_accept_negative_numbers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '0',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '-100'
        ]);

        $response->assertJson(['created'=> false]);
        $response->assertJsonValidationErrors(['billing_meter_ips']);
    }

    public function test_middle_name_if_saved_if_provided()
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $response = $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => 'Meowk',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '0',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> true]);
        $this->assertDatabaseCount('customers',1);
       
    }
}
