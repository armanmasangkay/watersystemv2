<?php

namespace Tests\Feature\admin;

use App\Classes\Facades\Helpers\Test\IsRouteAccessible;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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

    public function test_update_action_with_role_as_decimal_value()
    {
        $user=User::factory()->create();
        $userToUpdate=User::factory()->create([
            'role'=>User::$CASHIER
        ]);
        $response=$this->actingAs($user)->put(route('admin.users.update',$userToUpdate),[
            'role'=>'1.1',
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

        $cashierResponse=$this->actingAs($cashier)->put(route('admin.users.update',$admin),['role'=>User::$CASHIER,'name'=>'John']);
        $readerResponse=$this->actingAs($reader)->put(route('admin.users.update',$admin),['role'=>User::$CASHIER,'name'=>'John']);
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->put(route('admin.users.update',$admin),['role'=>User::$CASHIER,'name'=>'John']);
        $waterInspectorResponse=$this->actingAs($waterInspector)->put(route('admin.users.update',$admin),['role'=>User::$CASHIER,'name'=>'John']);
        $engResponse=$this->actingAs($engineer)->put(route('admin.users.update',$admin),['role'=>User::$CASHIER,'name'=>'John']);
        $adminResponse=$this->actingAs($admin)->put(route('admin.users.update',$admin),['role'=>User::$CASHIER,'name'=>'John']);

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertRedirect(route('admin.users.edit',$admin));
        
    }

    public function test_delete_route()
    {
        $user=User::factory()->create();
        $userToDelete=User::factory()->create([
            'role'=>User::$CASHIER
        ]);
        $response=$this->actingAs($user)->delete(route('admin.users.destroy',$userToDelete));
        $this->assertNull(User::find($userToDelete->id));
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas([
            'deleted'=>true,
            'message'=>"{$userToDelete->name}'s account was deleted successfully!"
        ]);
    }

    public function test_delete_route_is_only_accessible_to_admin()
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

        $cashierResponse=$this->actingAs($cashier)->delete(route('admin.users.destroy',$admin));
        $readerResponse=$this->actingAs($reader)->delete(route('admin.users.destroy',$admin));
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->delete(route('admin.users.destroy',$admin));
        $waterInspectorResponse=$this->actingAs($waterInspector)->delete(route('admin.users.destroy',$admin));
        $engResponse=$this->actingAs($engineer)->delete(route('admin.users.destroy',$admin));
        $adminResponse=$this->actingAs($admin)->delete(route('admin.users.destroy',$admin));

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertRedirect(route('admin.users.index'));
        $adminResponse->assertSessionHas([
            'deleted'=>true,
            'message'=>"{$admin->name}'s account was deleted successfully!"
        ]);
    }

    public function test_reset_password_route()
    {
        $user=User::factory()->create();
        $userToUpdatePassword=User::factory()->create([
            'role'=>User::$CASHIER,
            'password'=>Hash::make('09999')
        ]);
        $response=$this->actingAs($user)->put(route('admin.user-passwords.update',$userToUpdatePassword));
        $userWithResettedPassword=User::findOrFail($userToUpdatePassword->id);
        $this->assertTrue(Hash::check(User::defaultPassword(),$userWithResettedPassword->password));
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas([
            'resetted-password'=>true,
            'message'=>"{$userWithResettedPassword->name}'s password was resetted successfully!"
        ]); 
    }

    public function test_reset_password_route_is_only_accessible_to_admin()
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

        $admin=User::factory()->create([
            'password'=>Hash::make('1234')
        ]);

        $cashierResponse=$this->actingAs($cashier)->put(route('admin.user-passwords.update',$admin));
        $readerResponse=$this->actingAs($reader)->put(route('admin.user-passwords.update',$admin));
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->put(route('admin.user-passwords.update',$admin));
        $waterInspectorResponse=$this->actingAs($waterInspector)->put(route('admin.user-passwords.update',$admin));
        $engResponse=$this->actingAs($engineer)->put(route('admin.user-passwords.update',$admin));
        $adminResponse=$this->actingAs($admin)->put(route('admin.user-passwords.update',$admin));

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertRedirect(route('admin.users.index'));
        $adminResponse->assertSessionHas([
            'resetted-password'=>true,
            'message'=>"{$admin->name}'s password was resetted successfully!"
        ]);

    }

}
