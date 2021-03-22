<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewTransactionTest extends TestCase
{
    use RefreshDatabase;
    public function test_save_new_transaction()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)->post(route('admin.transactions.store'),[
            'customer_id'=>1,
            'type_of_service'=>'new water application',
            'remarks'=>'',
            'schedule'=>now()->format('Y-m-d')
        ]);
        $response->assertRedirect(route('admin.transactions.create'));
        $response->assertSessionHasAll([
            'created'=>true,
            'message'=>'Successfully created a new transaction.'
        ]);
        $this->assertDatabaseHas('transactions',[
            'customer_id'=>1,
            'type_of_service'=>'new water application',
            'remarks'=>null,
            'schedule'=>now()->format('Y-m-d')
        ]);
    }
    public function test_returns_an_error_if_schedule_is_not_provided()
    {
        $user=User::factory()->create();
        $customer=Customer::factory()->create();
        $response=$this->actingAs($user)->post(route('admin.transactions.store'),[
            'customer_id'=>$customer->account_number,
            'type_of_service'=>'new water application',
            'remarks'=>'',
            'schedule'=>''
        ]);

        $response->assertRedirect(route('admin.search-customer',['account_number'=>$customer->account_number]));
        $response->assertSessionHasErrors([
            'schedule'
        ]);

        $this->assertDatabaseCount('transactions',0);
    }
}
