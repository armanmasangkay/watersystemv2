<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CashierTest extends TestCase
{
    use RefreshDatabase;

    public function test_display_list_of_cashiers(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.cashiers.index'));

        $response->assertViewHasAll(['cashiers']);
        $response->assertViewIs('pages.cashiers');
    }

    public function test_redirect_to_create_cashiers_page(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.cashiers.create'));

        $response->assertViewIs('pages.cashier-create');
    }

    public function test_success_if_cashiers_data_is_valid(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.cashiers.store'),[
            'name' => "June Vic Cadayona",
            'username' => 'jvcadz',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseCount('users', 2);
        $response->assertRedirect(route('admin.cashiers.index'));
        $response->assertSessionHasAll(['created', 'message']);
    }

    public function test_success_if_cashiers_data_is_invalid(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.cashiers.store'),[
            'name' => "June Vic Cadayona",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_fail_if_password_does_not_match(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.cashiers.store'),[
            'name' => "June Vic Cadayona",
            'username' => 'jvcadz',
            'password' => '12345678',
            'password_confirmation' => '123456789'
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}
