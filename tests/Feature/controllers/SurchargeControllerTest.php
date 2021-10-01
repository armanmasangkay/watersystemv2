<?php

namespace Tests\Controllers\Feature;

use App\Models\Surcharge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SurchargeControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_redirect_to_login_if_the_user_is_unauthenticated_trying_to_access_the_surcharge_rates(){
        $response = $this->get(route('admin.surcharge-get'));
        $response->assertRedirect(route('login'));
    }
    public function test_return_surcharge_rate_if_the_user_is_authenticated()
    {
        $user = User::factory()->create();
        Surcharge::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.surcharge-get'));
        $data = ["rate" => 0.1];

        $response->assertJson(['data' => array($data)]);
    }
    public function test_success_if_surcharge_update_with_valid_data()
    {
        $user = User::factory()->create();
        Surcharge::factory()->create(['rate'=>'0.2']);
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => 10]);
        $this->assertDatabaseHas('surcharges', ['rate' => 0.1]);
        $response->assertJson(['updated' => true]);
    }
    public function test_fail_if_surcharge_update_with_invalid_data()
    {
        $user = User::factory()->create();
        Surcharge::factory()->create(['rate'=>'0.2']);
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => "sample"]);
        $response->assertJson(['updated' => false]);
    }
    public function test_fail_if_surcharge_is_negative()
    {
        $user = User::factory()->create();
        Surcharge::factory()->create(['rate'=>'0.2']);
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => "-1"]);
        $response->assertJson(['updated' => false]);
    }
}
