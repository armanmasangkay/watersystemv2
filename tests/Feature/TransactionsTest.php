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
        $responseCustomer=$response['customer'];
        $this->assertEquals($responseCustomer->account_number,$customer->account_number);
   }

   public function test_searching_for_a_non_existent_account_number()
   {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $response=$this->actingAs($user)->get(route('admin.search-customer',[
            'account_number'=>'020-022-111'
        ]));
        $response->assertViewIs('pages.customer-not-found');
        $response->assertViewHas('account_number','020-022-111');

      
   }
}
