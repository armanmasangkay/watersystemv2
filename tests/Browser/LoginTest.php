<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;
    
    public function test_login_form_can_login()
    {

        $this->browse(function (Browser $browser) {
            $user=User::factory()->create([
                'name'=>'Arman Masangkay',
                'username'=>'armanmasangkay',
                'password'=>Hash::make('1234')
            ]);

            $browser->visit(route('login'))
                    ->assertSee('Sign in')
                    ->type('username','armanmasangkay')
                    ->type('password','1234')
                    ->press('Log In')
                    ->assertAuthenticatedAs($user);
        });
    }
}
