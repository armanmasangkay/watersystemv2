<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RootRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_accessing_root_will_redirect_to_login_if_not_authenticated()
    {
       $response=$this->get('/');
       $response->assertRedirect(route('login'));
    }

    public function test_accessing_root_will_redirect_to_dashboard_if_authenticated()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);

        $response=$this->actingAs($user)->get('/');
        $response->assertRedirect(route('admin.dashboard'));
    }

}
