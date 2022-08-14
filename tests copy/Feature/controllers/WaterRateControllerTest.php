<?php

namespace Tests\Controllers\Feature;

use App\Models\Surcharge;
use App\Models\User;
use App\Models\WaterRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WaterRateControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_redirect_to_login_if_the_user_is_unauthenticated_trying_to_access_the_water_rates(){
        $response = $this->get(route('admin.water-rate-get'));
        $response->assertRedirect(route('login'));
    }
    public function test_return_water_rates_if_the_user_is_authenticated(){
        $user = User::factory()->create();
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Institutional']);
        WaterRate::factory()->create(['type' => 'Commercial', "min_rate" => 110, "excess_rate" => 15]);
        Surcharge::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.water-rate-get'));

        $data1 = [ "type" => "Residential", "consumption_max_range" => 10, "min_rate" => 65, "excess_rate" => 10];
        $data2 = ["type" => "Institutional", "consumption_max_range" => 10, "min_rate" => 65, "excess_rate" => 10];
        $data3 = ["type" => "Commercial", "consumption_max_range" => 10, "min_rate" => 110, "excess_rate" => 15];
        $response->assertJson(['data' => array($data1, $data2,$data3)]);
    }

    /**
     * @test
     */
    public function waterRateCanBeAccessableByAdmin()
    {
        $user = User::factory()->create();
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Institutional']);
        WaterRate::factory()->create(['type' => 'Commercial', "min_rate" => 110, "excess_rate" => 15]);
        Surcharge::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.water-rate-get'));
        $data1 = [ "type" => "Residential", "consumption_max_range" => 10, "min_rate" => 65, "excess_rate" => 10];
        $data2 = ["type" => "Institutional", "consumption_max_range" => 10, "min_rate" => 65, "excess_rate" => 10];
        $data3 = ["type" => "Commercial", "consumption_max_range" => 10, "min_rate" => 110, "excess_rate" => 15];
        $response->assertJson(['data' => array($data1, $data2,$data3)]);
    }

    /**
     * @test
     */
    public function waterRateCannotBeAccessableByCashier()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Institutional']);
        WaterRate::factory()->create(['type' => 'Commercial', "min_rate" => 110, "excess_rate" => 15]);
        Surcharge::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.water-rate-get'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function waterRateCannotBeAccessableByEngineer()
    {
        $user = User::factory()->create(['role' => User::$ENGINEER]);
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Institutional']);
        WaterRate::factory()->create(['type' => 'Commercial', "min_rate" => 110, "excess_rate" => 15]);
        Surcharge::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.water-rate-get'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function waterRateCannotBeAccessableByBldgInspector()
    {
        $user = User::factory()->create(['role' => User::$BLDG_INSPECTOR]);
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Institutional']);
        WaterRate::factory()->create(['type' => 'Commercial', "min_rate" => 110, "excess_rate" => 15]);
        Surcharge::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.water-rate-get'));
        $response->assertForbidden();
    }

    public function test_should_error_if_required_fields_are_not_provided()
    {
        $user = User::factory()->create();
        $response=$this->actingAs($user)->post(route('admin.water-rate-update'),[
            'type'=>'',
            'consumption_max_range'=>'',
            'min_rate'=>'',
            'excess_rate'=>''
        ]);
        $response->assertJsonValidationErrors(['type','min_rate','excess_rate']);
    }
    public function test_should_error_if_min_rate_is_negative()
    {
        $user = User::factory()->create();
        $response=$this->actingAs($user)->post(route('admin.water-rate-update'),[
            'type'=>'Residential',
            'consumption_max_range'=>'',
            'min_rate'=>'-1',
            'excess_rate'=>'100'
        ]);

        $response->assertJsonValidationErrors(['min_rate']);
    }
    public function test_should_error_if_excess_rate_is_negative()
    {
        $user = User::factory()->create();
        $response=$this->actingAs($user)->post(route('admin.water-rate-update'),[
            'type'=>'Residential',
            'consumption_max_range'=>'',
            'min_rate'=>'1',
            'excess_rate'=>'-100'
        ]);

        $response->assertJsonValidationErrors(['excess_rate']);
    }

    public function test_should_update_if_all_data_is_valid()
    {
        $user = User::factory()->create();
        $waterRate=WaterRate::factory()->create();

        $response=$this->actingAs($user)->post(route('admin.water-rate-update'),[
            'id'=>$waterRate->id,
            'type'=>'Residential',
            'consumption_max_range'=>10,
            'min_rate'=>10,
            'excess_rate'=>1000
        ]);

        $this->assertDatabaseHas('water_rates',['excess_rate'=>1000]);

        $response->assertJson(['updated'=>true]);
    }

    public function test_should_not_update_if_id_is_not_provided()
    {
        $user = User::factory()->create();
        $response=$this->actingAs($user)->post(route('admin.water-rate-update'),[
            'type'=>'Residential',
            'consumption_max_range'=>10,
            'min_rate'=>10,
            'excess_rate'=>1000
        ]);
        $response->assertJson(['updated'=>false]);
        $response->assertJsonValidationErrors(['id']);
    }
}
