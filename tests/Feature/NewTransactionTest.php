<?php

namespace Tests\Feature;

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
            'type_of_service'=>'new water application',
            'remarks'=>null,
            'schedule'=>now()->format('Y-m-d')
        ]);
    }
}
