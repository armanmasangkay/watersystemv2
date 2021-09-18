<?php

namespace Tests\Feature\admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;
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
}
