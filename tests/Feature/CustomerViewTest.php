<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerViewTest extends TestCase
{

    use RefreshDatabase;

    public function test_view_all_customer_should_show_no_data_if_theres_no_current_customer_registered()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $response=$this->actingAs($user)->get(route('admin.customers'));
        $response->assertOk();
        $response->assertSeeText("There's no currently registered customer.");
    }

    public function test_view_all_customer_can_be_rendered()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);

        $customers=Customer::factory()->count(20)->create();
    
        $response=$this->actingAs($user)->get(route('admin.customers'));
        $response->assertOk();
        $response->assertViewHas('customers');
        $response->assertViewIs('pages.customers-list');
        
        $civilStatus=ucfirst($customers[0]->civil_status);
        $connectionType=ucfirst($customers[0]->connection_type);
        $connectionStatus=ucfirst($customers[0]->connection_status);
    

        //make sure all text is normalized
        $response->assertSeeText($civilStatus);
        $response->assertSeeText($connectionType);
        $response->assertSeeText($connectionStatus);

        //ensure it is paginated by 10
        $this->assertTrue(count($response['customers'])<=10);

 
    }
    
}
