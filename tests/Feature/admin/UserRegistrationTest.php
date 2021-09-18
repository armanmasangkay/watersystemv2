<?php

namespace Tests\Feature\admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
   public function test_route()
   {
       $user=User::factory()->create();
       $response=$this->actingAs($user)->get(route('admin.users.index'));
       $response->assertOk();
       $response->assertViewIs('pages.users.index');
       $response->assertViewHas(['users']);
   }

   public function test_route_is_accessible_only_to_admin()
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

        $cashierResponse=$this->actingAs($cashier)->get(route('admin.dashboard'));
        $readerResponse=$this->actingAs($reader)->get(route('admin.dashboard'));
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->get(route('admin.dashboard'));
        $waterInspectorResponse=$this->actingAs($waterInspector)->get(route('admin.dashboard'));
        $engResponse=$this->actingAs($engineer)->get(route('admin.dashboard'));
        $adminResponse=$this->actingAs($admin)->get(route('admin.dashboard'));

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertOk();
   }
}
