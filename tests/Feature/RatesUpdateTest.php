<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatesUpdateTest extends TestCase
{
    use RefreshDatabase;
    public function test_success_if_surcharge_update_with_valid_data(){
        $user = User::factory()->create();
        Artisan::call('db:seed --class=SurchargeSeeder');
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => 10]);
        $this->assertDatabaseHas('surcharges', ['rate' => 0.1]);
        $response->assertJson(['updated' => true]);
    }
    public function test_fail_if_surcharge_update_with_invalid_data(){
        $user = User::factory()->create();
        Artisan::call('db:seed --class=SurchargeSeeder');
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => "sample"]);
        $response->assertJson(['updated' => false]);
    }

    public function test_success_if_water_rates_update_with_valid_data(){
        $user = User::factory()->create();
        Artisan::call('db:seed --class=WaterRateSeeder');
        $response =$this->actingAs($user)->post(route('admin.water-rate-update'),['type' => 1,'min_rate' => 10,'excess_rate' => 10]);
        $this->assertDatabaseHas('water_rates', ['type' => "Residential"]);
        $response->assertJson(['updated' => true]);
    }
    public function test_fail_if_water_rates_update_with_invalid_data(){
        $user = User::factory()->create();
        Artisan::call('db:seed --class=WaterRateSeeder');
        $response =$this->actingAs($user)->post(route('admin.water-rate-update'),['min_rate' => 10,'excess_rate' => 10]);

        $response->assertJson(['updated' => false]);
    }
}
