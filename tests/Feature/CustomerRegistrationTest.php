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

    public function test_fail_to_register_if_date_is_beyond(){
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
}
