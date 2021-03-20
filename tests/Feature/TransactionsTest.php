<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;



    public function test_new_transactions_route_renders_correct_view()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $response=$this->actingAs($user)->get(route('admin.new-transaction'));
        $response->assertViewIs('pages.new-transaction');
        $response->assertOk();
    }

    public function test_search_for_invalid_customer_number_will_return_an_error_and_old_input()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        Customer::factory()->create();
        $response=$this->actingAs($user)->get(route('admin.search-customer',[
            'account_number'=>'1231231231'
        ]));
     
        $response->assertRedirect(route('admin.new-transaction'));
        $response->assertSessionHasInput(['account_number']);
        $response->assertSessionHasErrors([
            'account_number'
        ]);
    
    }

   public function test_search_customer_using_account_number_returns_customer_data()
   {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $customer=Customer::factory()->create();
        
        $accountNumber=$customer->account_number;
     
        $response=$this->actingAs($user)->get(route('admin.search-customer',[
        'account_number'=>$accountNumber
        ]));

        $response->assertViewIs('pages.new-transaction');
        $response->assertViewHas('customer');
        $response->assertSessionHasInput('account_number');
        $responseCustomer=$response['customer'];
        $this->assertEquals($responseCustomer->account_number,$customer->account_number);
   }

 
}
