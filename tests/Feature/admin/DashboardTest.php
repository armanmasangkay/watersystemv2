<?php

namespace Tests\Feature\admin;

use App\Classes\Facades\Helpers\Test\IsRouteAccessible;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_route()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertViewIs('pages.dashboard');
        $response->assertViewHas('data');
      
    }

    public function test_should_be_accessible_to_admin_only()
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

        $cashierResponse=$this->actingAs($cashier)->get(route('admin.dashboard',$admin));
        $readerResponse=$this->actingAs($reader)->get(route('admin.dashboard',$admin));
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->get(route('admin.dashboard',$admin));
        $waterInspectorResponse=$this->actingAs($waterInspector)->get(route('admin.dashboard',$admin));
        $engResponse=$this->actingAs($engineer)->get(route('admin.dashboard',$admin));
        $adminResponse=$this->actingAs($admin)->get(route('admin.dashboard',$admin));

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertOk();
    }


}
