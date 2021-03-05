<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;
   public function test_create_new_transaction_view_can_be_rendered()
   {   
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);

        $response=$this->actingAs($user)->get(route('admin.new-transaction'));

        $response->assertViewIs('pages.new-transaction');
       
   }
}
