<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route()
    {
        $response=$this->get(route('login'));

        $response
            ->assertOk()
            ->assertViewIs('pages.login');
    }

    public function test_redirect_back_to_login_page_if_credentials_are_invalid()
    {
        $user=User::factory()->create();

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'12345'
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasInput('username',$user->username);
    }

    public function test_successful_admin_login_should_redirect_to_dashboard()
    {
        $user=User::factory()->create();

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_successful_cashier_login_should_redirect_to_intended_route()
    {
        $user=User::factory()->create([
            'role'=>User::$CASHIER
        ]);

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('admin.existing-customers.index'));
    }

    public function test_successful_meter_reader_login_should_redirect_to_intended_route()
    {
        $user=User::factory()->create([
            'role'=>User::$READER
        ]);

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('admin.home'));
    }

    public function test_successful_building_inspector_login_should_redirect_to_intended_route()
    {
        $user=User::factory()->create([
            'role'=>User::$BLDG_INSPECTOR
        ]);

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('admin.request-approvals'));
    }

    public function test_successful_waterworks_inspector_login_should_redirect_to_intended_route()
    {
        $user=User::factory()->create([
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('admin.waterworks-request-approvals'));
    }

    public function test_successful_engineer_login_should_redirect_to_intended_route()
    {
        $user=User::factory()->create([
            'role'=>User::$ENGINEER
        ]);

        $response=$this->post('/login',[
            'username'=>$user->username,
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('admin.municipal-engineer.index'));
    }

    public function test_correct_password_but_incorrect_username_should_still_be_invalid()
    {
        $user=User::factory()->create([
            'role'=>User::$CASHIER
        ]);

        $response=$this->post('/login',[
            'username'=>'incorrectusername',
            'password'=>'1234'
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasInput('username','incorrectusername');
    }
}
