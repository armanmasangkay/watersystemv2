<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CustomerRegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;
    public function test_registration_form()
    {
        $this->browse(function (Browser $browser) {
            $user=User::factory()->create([
                'name'=>'Arman Masangkay',
                'username'=>'armanmasangkay',
                'password'=>Hash::make('1234')
            ]);

            $browser->loginAs($user)
                    ->visit(route('admin.register-customer'))
                    ->assertSee("Register a Customer")
                    ->type('firstname','Arman')
                    ->type('middlename','Macasuhot')
                    ->type('lastname','Masangkay')
                    ->select('civil_status','married')
                    ->type('purok','Purok 1')
                    ->select('barangay','Amparo')
                    ->type('contact_number','09757375747')
                    ->select('connection_type','institutional')
                    ->select('connection_status','active')
                    ->press('Register')
                    ->waitForText('Customer account was successfully created!');

            $this->assertDatabaseCount('customers',1);
            $this->assertDatabaseHas('customers',[
                'firstname'=>'Arman',
                'lastname'=>'Masangkay',
                'middlename'=>'Macasuhot'
            ]);

        });
    }


    public function test_selections_have_first_letter_being_uppercased_on_the_display_text()
    {
        $this->browse(function (Browser $browser) {
            $user=User::factory()->create([
                'name'=>'Arman Masangkay',
                'username'=>'armanmasangkay',
                'password'=>Hash::make('1234')
            ]);

            $browser->loginAs($user)
                    ->visit(route('admin.register-customer'))
                    ->assertSeeIn("#civil_status",'Single')
                    ->assertSeeIn("#connection-type","Residential")
                    ->assertSeeIn("#connection-status","Active");
        });
    }

    public function test_fields_to_show_validation_errors_if_a_field_has_errors_after_submitting()
    {
        $this->browse(function (Browser $browser) {
            $user=User::factory()->create([
                'name'=>'Arman Masangkay',
                'username'=>'armanmasangkay',
                'password'=>Hash::make('1234')
            ]);

            $browser->loginAs($user)
                    ->visit(route('admin.register-customer'))
                    ->assertMissing("#error-firstname")
                    ->assertMissing('#error-lastname')
                    ->assertMissing('#error-contact-number')
                    ->assertMissing('#error-purok')
                    ->pressAndWaitFor('Register',2)
                    ->assertVisible('#error-firstname')
                    ->assertVisible('#error-lastname')
                    ->assertVisible('#error-contact-number')
                    ->assertVisible('#error-purok')
                    
        });
    }
}
