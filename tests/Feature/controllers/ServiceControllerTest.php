<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_a_view_if_account_number_exist_when_searching()
    {
        $user=User::factory()->create();

        $customer=Customer::factory()->create();

        $this->actingAs($user);

        $response=$this->get(route('admin.services.search',[
            'account_number'=>$customer->account_number
        ]));

        $response
            ->assertViewIs('pages.add-service')
            ->assertViewHas([
                'route',
                'services',
                'customer'
            ]);
    }

    public function test_it_should_return_an_error_if_account_number_does_not_exist_when_searching()
    {
        $user=User::factory()->create();

        $this->actingAs($user);

        $response=$this->get(route('admin.services.search',[
            'account_number'=>'1231231'
        ]));

        $response
            ->assertRedirect(route('admin.services.create'))
            ->assertSessionHasErrors([
                'account_number'=>'Account number not found!'
            ])
            ->assertSessionHasInput('account_number');
    }
}
