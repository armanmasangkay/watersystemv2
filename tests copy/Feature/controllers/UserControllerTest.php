<?php

namespace Tests\Controllers\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
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

        $cashierResponse=$this->actingAs($cashier)->get(route('admin.users.index'));
        $readerResponse=$this->actingAs($reader)->get(route('admin.users.index'));
        $bldgInspectorResponse=$this->actingAs($bldgInspector)->get(route('admin.users.index'));
        $waterInspectorResponse=$this->actingAs($waterInspector)->get(route('admin.users.index'));
        $engResponse=$this->actingAs($engineer)->get(route('admin.users.index'));
        $adminResponse=$this->actingAs($admin)->get(route('admin.users.index'));

        $cashierResponse->assertForbidden();
        $readerResponse->assertForbidden();
        $bldgInspectorResponse->assertForbidden();
        $waterInspectorResponse->assertForbidden();
        $engResponse->assertForbidden();
        $adminResponse->assertOk();
   }

   public function test_storing_user_valid_data()
   {
        $admin=User::factory()->create();
        $response=$this->actingAs($admin)->post(route('admin.users.store'),[
            'name'=>'John',
            'username'=>'arman',
            'password'=>'12345678',
            'password_confirmation'=>'12345678',
            'role'=>User::$ADMIN
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHasAll([
            'created'=>true,
            'message'=>'User Account created successfully!'
        ]);

   }
   public function test_storing_user_without_name()
   {
        $admin=User::factory()->create();
        $response=$this->actingAs($admin)->post(route('admin.users.store'),[
            'name'=>'',
            'username'=>'arman',
            'password'=>'12345678',
            'password_confirmation'=>'12345678',
            'role'=>User::$ADMIN
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('created',false);
        $response->assertSessionHasErrors(['name']);
   }

   public function test_storing_user_with_existing_username()
   {
        $admin=User::factory()->create();
        User::factory()->create([
            'username'=>'arman'
        ]);
        $response=$this->actingAs($admin)->post(route('admin.users.store'),[
            'name'=>'John',
            'username'=>'arman',
            'password'=>'12345678',
            'password_confirmation'=>'12345678',
            'role'=>User::$ADMIN
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('created',false);
        $response->assertSessionHasErrors(['username']);
   }
   public function test_storing_user_with_mismatch_password()
   {
        $admin=User::factory()->create();
        User::factory()->create([
            'username'=>'arman'
        ]);
        $response=$this->actingAs($admin)->post(route('admin.users.store'),[
            'name'=>'John',
            'username'=>'arman',
            'password'=>'12345678',
            'password_confirmation'=>'1234567899',
            'role'=>User::$ADMIN
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('created',false);
        $response->assertSessionHasErrors(['password']);
   }

   public function test_storing_user_with_no_role_selected()
   {
        $admin=User::factory()->create();
        User::factory()->create([
            'username'=>'arman'
        ]);
        $response=$this->actingAs($admin)->post(route('admin.users.store'),[
            'name'=>'John',
            'username'=>'arman',
            'password'=>'12345678',
            'password_confirmation'=>'1234567899',
            'role'=>''
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('created',false);
        $response->assertSessionHasErrors(['role']);
   }

   public function test_update_password_route_can_only_be_accessed_if_logged_in()
   {   
        $response=$this->get(route('users.update-password.edit'));
        $response
            ->assertRedirect(route('login'));
   }

   public function test_update_password_route_with_authenticated_user()
   {
       $user=User::factory()->create();
        $response=$this->actingAs($user)->get(route('users.update-password.edit'));
        $response
            ->assertOk()
            ->assertViewIs('pages.users.change-password');
   }

   public function test_store_new_password_route_with_valid_data()
   {
       $user=User::factory()->create();
        $response=$this->actingAs($user)->put(route('users.update-password.store'),[
            'current_password'=>'1234',
            'password'=>'987654321',
            'password_confirmation'=>'987654321'
        ]);

        $userWithNewPass=User::findOrFail($user->id);

        $this->assertTrue(Hash::check('987654321',$userWithNewPass->password));
        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasAll([
                'updated-password'=>true,
                'message'=>'Password updated successfully! You may log-in again.'
            ]);

        $this->assertGuest();

   }

   public function test_store_new_password_should_fail_if_provided_with_lower_than_8_characters()
   {
       $user=User::factory()->create();
        $response=$this->actingAs($user)->put(route('users.update-password.store'),[
            'current_password'=>'1234',
            'password'=>'654321',
            'password_confirmation'=>'654321'
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors([
                'password'
            ]);

   }

   public function test_store_new_password_should_fail_if_current_password_is_incorrect()
   {
       $user=User::factory()->create();
        $response=$this->actingAs($user)->put(route('users.update-password.store'),[
            'current_password'=>'123',
            'password'=>'654321',
            'password_confirmation'=>'654321'
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors([
                'current_password'
            ]);
   }

   public function test_store_new_password_should_fail_if_new_password_is_not_confirmed()
   {
       $user=User::factory()->create();
        $response=$this->actingAs($user)->put(route('users.update-password.store'),[
            'current_password'=>'1234',
            'password'=>'654321',
            'password_confirmation'=>'65432122'
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHasErrors([
                'password'
            ]);
   }


}
