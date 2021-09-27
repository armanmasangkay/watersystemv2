<?php namespace App\Services\Testing;

use App\Models\User;
use Tests\TestCase;
class RoleAccessService{


    private $testCase;
    public function __construct(TestCase $testCase)
    {
        $this->testCase=$testCase;
        
    }

    public function forAdminOnlyGet($route)
    {
        $user=User::factory()->create();
        $response=$this->testCase->actingAs($user)->get($route); 
        $response->assertOk();

        $user=User::factory()->create([
            'role'=>User::$CASHIER
        ]);
        $response=$this->testCase->actingAs($user)->get($route); 
        $response->assertForbidden();

        $user=User::factory()->create([
            'role'=>User::$BLDG_INSPECTOR
        ]);
        $response=$this->testCase->actingAs($user)->get($route); 
        $response->assertForbidden();

        $user=User::factory()->create([
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);
        $response=$this->testCase->actingAs($user)->get($route); 
        $response->assertForbidden();

        $user=User::factory()->create([
            'role'=>User::$READER
        ]);
        $response=$this->testCase->actingAs($user)->get($route); 
        $response->assertForbidden();

        $user=User::factory()->create([
            'role'=>User::$ENGINEER
        ]);
        $response=$this->testCase->actingAs($user)->get($route); 
        $response->assertForbidden();
    }
}