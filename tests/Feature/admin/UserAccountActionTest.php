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

    public function test_update_action_should_not_accept_if_required_fields_are_empty()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)->put(route('admin.users.update',$user),[
            'role'=>'',
            'name'=>'',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['role','name']);
    }
    public function test_update_action_with_valid_data()
    {
        $user=User::factory()->create();
        $userToUpdate=User::factory()->create([
            'role'=>User::$CASHIER
        ]);
        $response=$this->actingAs($user)->put(route('admin.users.update',$userToUpdate),[
            'role'=>User::$ADMIN,
            'name'=>'Armando Masangkay',
        ]);

        $updatedUser=User::findOrFail($userToUpdate->id);
        $response->assertRedirect(route('admin.users.edit',$updatedUser));
        $this->assertTrue($updatedUser->role===User::$ADMIN);
        $this->assertTrue($updatedUser->name==='Armando Masangkay');
        $response->assertSessionHasAll([
            'updated'=>true,
            'message'=>"Account was updated successfully!"
        ]);
    }

    public function test_update_action_with_string_as_role_value()
    {
        $user=User::factory()->create();
        $userToUpdate=User::factory()->create([
            'role'=>User::$CASHIER
        ]);
        $response=$this->actingAs($user)->put(route('admin.users.update',$userToUpdate),[
            'role'=>'InvalidRole',
            'name'=>'Armando Masangkay',
        ]);
        $response->dump();
        $response->assertRedirect();
        $response->assertSessionHasErrors(['role']);
    }

    public function test_update_action_with_invalid_role()
    {
        $user=User::factory()->create();
        $userToUpdate=User::factory()->create([
            'role'=>User::$CASHIER
        ]);
        $response=$this->actingAs($user)->put(route('admin.users.update',$userToUpdate),[
            'role'=>'110',
            'name'=>'Armando Masangkay',
        ]);
   
        $response->assertRedirect();
        $response->assertSessionHasErrors(['role']);
    }

    public function test_update_action_should_only_be_accessible_to_admin()
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
