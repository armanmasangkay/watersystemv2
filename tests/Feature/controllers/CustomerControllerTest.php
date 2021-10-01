<?php

namespace Tests\Controllers\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;


    private function create_customer_with_transaction($user){
        $date = Carbon::now();
        $this->actingAs($user)->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'meter_serial_number'=>'12344',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
    }

    public function test_get_consumer_bill(){
        $user = User::factory()->create();
        $this->create_customer_with_transaction($user);
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();
       
        $response = $this->post(route('admin.get-bill', ['id' =>$transaction->id]), ['customer_id' => $customer->account_number]);

        $response->assertJson(['getBill' => true]);
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
            'meter_serial_number'=>'123',
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
            'meter_serial_number'=>'123',
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
            'meter_serial_number'=>'123',
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
            'meter_serial_number'=>'123',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
        $this->assertDatabaseCount('customers', 1);
        $response->assertJson(['created'=> true]);

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

    public function test_registraation_must_be_successful_if_customer_has_complete_and_valid_data(){
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
            'meter_serial_number'=>'123',
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
            'meter_serial_number'=>'123',
            'reading_meter' => '0',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);

        $response->assertJson(['created'=> true]);
        $this->assertDatabaseCount('customers',1);

    }

    public function test_should_not_save_if_meter_reader_already_exist_on_an_exist_customer()
    {
        $user = User::factory()->create();
        $existingCustomer=Customer::factory()->create();
        $date = Carbon::now();
      
        $response = $this->actingAs($user)->post(route('admin.register-customer.store'),[
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
            'meter_serial_number'=>$existingCustomer->meter_number,
            'reading_meter' => '0',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
        $response->assertJson(['created'=> false]);
        $response->assertJsonValidationErrors(['meter_serial_number']);

    }
}
