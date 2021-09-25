<?php namespace App\Classes\Facades\Helpers\Test;

use App\Models\User;
use Tests\TestCase;

class IsRouteAccessible
{

    private $testCase;
    public function __construct(TestCase $testCase)
    {
        $this->testCase=$testCase;
    }
    public function withRole($allowedRole,$route,$method)
    {
        $cashier=User::factory()->create([
            'role'=>User::$CASHIER
        ]);

        $reader=User::factory()->create([
            'role'=>User::$READER
        ]);

        $bldgInspector=User::factory()->create([
            'role'=>User::$BLDG_INSPECTOR
        ]);

        $waterInspector=User::factory()->create([
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);

        $engineer=User::factory()->create([
            'role'=>User::$ENGINEER
        ]);

        $admin=User::factory()->create();


    
        if($method=="GET"){
            $cashierResponse=$this->testCase->actingAs($cashier)->get($route);
            $readerResponse=$this->testCase->actingAs($reader)->get($route);
            $bldgInspectorResponse=$this->testCase->actingAs($bldgInspector)->get($route);
            $waterInspectorResponse=$this->testCase->actingAs($waterInspector)->get($route);
            $engResponse=$this->testCase->actingAs($engineer)->get($route);
            $adminResponse=$this->testCase->actingAs($admin)->get($route);
        }

        if($method=="POST"){
            $cashierResponse=$this->testCase->actingAs($cashier)->post($route);
            $readerResponse=$this->testCase->actingAs($reader)->post($route);
            $bldgInspectorResponse=$this->testCase->actingAs($bldgInspector)->post($route);
            $waterInspectorResponse=$this->testCase->actingAs($waterInspector)->post($route);
            $engResponse=$this->testCase->actingAs($engineer)->post($route);
            $adminResponse=$this->testCase->actingAs($admin)->post($route);
        }

        if($method=="PUT"){
            $cashierResponse=$this->testCase->actingAs($cashier)->put($route);
            $readerResponse=$this->testCase->actingAs($reader)->put($route);
            $bldgInspectorResponse=$this->testCase->actingAs($bldgInspector)->put($route);
            $waterInspectorResponse=$this->testCase->actingAs($waterInspector)->put($route);
            $engResponse=$this->testCase->actingAs($engineer)->put($route);
            $adminResponse=$this->testCase->actingAs($admin)->put($route);
        }

        if($method=="DELETE"){
            $cashierResponse=$this->testCase->actingAs($cashier)->delete($route);
            $readerResponse=$this->testCase->actingAs($reader)->delete($route);
            $bldgInspectorResponse=$this->testCase->actingAs($bldgInspector)->delete($route);
            $waterInspectorResponse=$this->testCase->actingAs($waterInspector)->delete($route);
            $engResponse=$this->testCase->actingAs($engineer)->delete($route);
            $adminResponse=$this->testCase->actingAs($admin)->delete($route);
        }

      
        $allowedRole==User::$CASHIER? $cashierResponse->assertOk():$cashierResponse->assertForbidden();
        $allowedRole==User::$READER? $readerResponse->assertOk():$readerResponse->assertForbidden();
        $allowedRole==User::$BLDG_INSPECTOR? $bldgInspectorResponse->assertOk():$bldgInspectorResponse->assertForbidden();
        $allowedRole==User::$WATERWORKS_INSPECTOR? $waterInspectorResponse->assertOk():$waterInspectorResponse->assertForbidden();
        $allowedRole==User::$ENGINEER? $engResponse->assertOk():$engResponse->assertForbidden();
        $allowedRole==User::$ADMIN? $adminResponse->assertOk():$adminResponse->assertForbidden();
    }
}