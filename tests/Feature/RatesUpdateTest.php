<?php

namespace Tests\Feature;

use App\Models\Surcharge;
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
        Surcharge::factory()->create(['rate'=>'0.2']);
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => 10]);
        $this->assertDatabaseHas('surcharges', ['rate' => 0.1]);
        $response->assertJson(['updated' => true]);
    }
    public function test_fail_if_surcharge_update_with_invalid_data(){
        $user = User::factory()->create();
        Surcharge::factory()->create(['rate'=>'0.2']);
        $response = $this->actingAs($user)->post(route('admin.surcharge-update'),['surcharge_rate' => "sample"]);
        $response->assertJson(['updated' => false]);
    }

}
