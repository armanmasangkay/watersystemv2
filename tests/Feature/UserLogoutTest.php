<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
   use RefreshDatabase;
    public function test_logout()
    {
        $user=User::factory()->create([
            'name'=>'Arman Masangkay',
            'username'=>'amasangkay',
            'password'=>Hash::make('1234')
        ]);
        $response = $this->actingAs($user)->post(route('admin.logout'));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    
    }
}
