<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ConsumersListTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_consumers_route()
    {
        $customer=Customer::create([
            'account_number'=>'1',
            'firstname'=>'Arman',
            'middlename'=>'Macasuhot',
            'lastname'=>'Masangkay',
            'civil_status'=>'Married',
            'purok'=>'Purok 1',
            'barangay'=>'Barangay 1',
            'contact_number'=>'09757375747',
            'connection_type'=>'Sample Type',
            'connection_status'=>'Sample Status',
            'purchase_option'=>'Sample Option',
            'org_name'=>'Sample org name'
        ]);

        $user=User::factory()->create();
        
        $response=$this->actingAs($user)
                       ->get(route('admin.existing-customers.index'));

        $response->assertViewIs('pages.customers-list');
        $response->assertViewHas('customers');
        $this->assertInstanceOf(LengthAwarePaginator::class,$response->viewData('customers'));
    }

    
    public function test_reroute_to_login_page_when_not_authenticated()
    {  
        $response=$this->get(route('admin.existing-customers.index'));
        $response->assertRedirect(route('login'));
    }
    public function test_is_accessible_to_cashier_account()
    {
        $cashier=User::factory()->create([
            'role'=>User::$CASHIER
        ]);

        $response=$this->actingAs($cashier)->get(route('admin.existing-customers.index'));
        $response->assertOk();
    }
}
