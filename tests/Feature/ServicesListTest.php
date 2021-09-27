<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServicesListTest extends TestCase
{
    use RefreshDatabase;
    public function test_service_list_should_be_accessable(){
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $service = Service::factory()->create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_BUILDING_INSPECTION,
            'start_status' => Service::$PENDING_BUILDING_INSPECTION,
            'request_number' => Service::generateUniqueIdentifier()
        ]);
        $response = $this->actingAs($user)->get(route('admin.services.index'));
        $response->assertViewIs('pages.services-list');
        $response->assertViewHas('services');
    }


}
