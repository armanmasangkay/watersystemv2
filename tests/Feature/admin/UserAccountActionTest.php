<?php

namespace Tests\Feature\admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAccountActionTest extends TestCase
{
    public function test_edit_route()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)->get(route('admin.users.edit',$user));
        $response->assertOk();
        $response->assertViewIs('pages.users.edit');
        $response->assertViewHasAll(['user','roles']);
    }

    public function test_edit_route_only_accessible_to_admin()
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

        $cashierResponse=$this->actingAs($cashier)->get(route('admin.users.edit',$admin));
        $readerResponse=$this->actingAs($reader)->get(route('admin.users.edit',$admin));
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->get(route('admin.users.edit',$admin));
        $waterInspectorResponse=$this->actingAs($waterInspector)->get(route('admin.users.edit',$admin));
        $engResponse=$this->actingAs($engineer)->get(route('admin.users.edit',$admin));
        $adminResponse=$this->actingAs($admin)->get(route('admin.users.edit',$admin));

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertOk();
    }
}
