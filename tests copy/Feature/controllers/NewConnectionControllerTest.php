<?php

namespace Tests\Controllers\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewConnectionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_connection_form_is_accessable_when_user_is_authenticated(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.new-connection.create'));

        $response->assertViewIs('pages.new-consumer');
    }

    public function test_submit_form_with_complete_data_required_fields_are_not_empty(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.new-connection.store'),[
            'firstname' => 'Julius Amfil',
            'middlename' => 'Enoc',
            'lastname' => 'Dublado',
            'civil_status' => 'single',
            'contact_number' => '12345678910',
            'barangayCode' => '01',
            'barangay' => 'Aguinaldo',
            'purokCode' => '01',
            'purok' => 'Purok Lapok',
            'connection_type' => 'commercial',
            'connection_status' => 'inactive',
            'purchase_option' => 'cash',
        ]);

        $response->assertJson(['created' => true]);
        $this->assertDatabaseHas('customers', ['firstname' => 'Julius Amfil']);
        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseCount('transaction_logs', 1);
        $this->assertDatabaseCount('services', 1);
    }

    public function test_save_to_database_if_organization_name_is_provided()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.new-connection.store'),[
            'org_name' => 'SLSU',
            'firstname' => 'Julius Amfil',
            'middlename' => 'Enoc',
            'lastname' => 'Dublado',
            'civil_status' => 'single',
            'contact_number' => '12345678910',
            'barangayCode' => '01',
            'barangay' => 'Aguinaldo',
            'purokCode' => '01',
            'purok' => 'Purok Lapok',
            'connection_type' => 'commercial',
            'connection_status' => 'inactive',
            'purchase_option' => 'cash',
        ]);

        $response->assertJson(['created' => true]);
        $this->assertDatabaseHas('customers', ['org_name' => 'SLSU']);
        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseCount('transaction_logs', 1);
        $this->assertDatabaseHas('transaction_logs', ['customer_organization_name' => 'SLSU']);
        $this->assertDatabaseCount('services', 1);
    }

    public function test_should_fail_if_contact_number_is_less_than_or_greater_than_eleven_digits_(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.new-connection.store'),[
            'org_name' => 'SLSU',
            'firstname' => 'Julius Amfil',
            'middlename' => 'Enoc',
            'lastname' => 'Dublado',
            'civil_status' => 'single',
            'contact_number' => '12345678',
            'barangayCode' => '01',
            'barangay' => 'Aguinaldo',
            'purokCode' => '01',
            'purok' => 'Purok Lapok',
            'connection_type' => 'commercial',
            'connection_status' => 'inactive',
            'purchase_option' => 'cash',
        ]);

        $response->assertJson(['created' => false, 'errors' => ['contact_number' => []]]);
        $this->assertDatabaseCount('customers', 0);
        $this->assertDatabaseCount('transaction_logs', 0);
        $this->assertDatabaseCount('services', 0);
    }

    public function test_should_fail_if_contact_number_is_user_input_string(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.new-connection.store'),[
            'org_name' => 'SLSU',
            'firstname' => 'Julius Amfil',
            'middlename' => 'Enoc',
            'lastname' => 'Dublado',
            'civil_status' => 'single',
            'contact_number' => 'sample',
            'barangayCode' => '01',
            'barangay' => 'Aguinaldo',
            'purokCode' => '01',
            'purok' => 'Purok Lapok',
            'connection_type' => 'commercial',
            'connection_status' => 'inactive',
            'purchase_option' => 'cash',
        ]);

        $response->assertJson(['created' => false, 'errors' => ['contact_number' => []]]);
        $this->assertDatabaseCount('customers', 0);
        $this->assertDatabaseCount('transaction_logs', 0);
        $this->assertDatabaseCount('services', 0);
    }
}
