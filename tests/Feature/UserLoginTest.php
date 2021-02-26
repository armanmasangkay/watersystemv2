<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{

    use RefreshDatabase;
    public function test_login_form_can_be_rendered()
    {
        $response=$this->get(route('login'));
        $response->assertViewIs('pages.login');
    }

    public function test_login_form_will_redirect_to_any_other_routes_and_not_to_itself_when_authenticated()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);


        $response=$this->post(route('login'),[
            'username'=>$user->username,
            'password'  =>$user->password
        ]);

        $response->assertDontSeeText('Sign in');
    }

    public function test_invalid_credentials_should_redirect_back_to_login_form()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $response=$this->post(route('login'),[
            'username'=>$user->username,
            'password'  =>'wrongpassword'
        ]);
        $response->assertRedirect(route('login'));
        $response->assertSessionHasInput(['username']);

    }

    
}
