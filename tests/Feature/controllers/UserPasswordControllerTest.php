<?php

namespace Tests\Controllers\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserPasswordControllerTest extends TestCase
{
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
