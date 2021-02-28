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

    public function test_failed_login_should_have_username_field_to_have_the_previous_value()
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
                    ->type('password','wrongpassword')
                    ->press('Log In')
                    ->waitForRoute('login')
                    ->assertAttribute('#username','value','armanmasangkay');
    
                   
        });
    }

    public function test_login_failed_will_show_an_error_message()
    {
        $this->browse(function (Browser $browser) {
            $user=User::factory()->create([
                'name'=>'Arman Masangkay',
                'username'=>'armanmasangkay',
                'password'=>Hash::make('1234')
            ]);

            $browser->visit(route('login'))
                    ->assertSee('Sign in')
                    ->assertDontSee("Invalid credentials!")
                    ->type('username','armanmasangkay')
                    ->type('password','wrongpassword')
                    ->press('Log In')
                    ->waitForRoute('login')
                    ->assertSee("Invalid credentials!");

           
       
        });
    }
}
