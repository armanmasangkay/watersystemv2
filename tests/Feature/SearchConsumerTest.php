<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchConsumerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_redirect_back_with_errors_when_keyword_is_not_supplied()
    {
        $user=User::factory()->create();

        $response=$this->actingAs($user)
                       ->get(route('admin.searched-customers.index'));
        $response->assertRedirect(route('admin.searched-customers.index'))
                 ->assertSessionHasErrors('keyword');

    }

    public function test_view_if_a_valid_keyword_is_supplied()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)
                       ->get(route('admin.searched-customers.index',['keyword','Arman']));

        $response->assertRedirect();
    }

    public function test_search_customer_uri_is_not_accessible_to_unauthenticated_user()
    {
        $user=User::factory()->create();
        $response=$this->get(route('admin.searched-customers.index').'?keyword=Arman'); 
        $response->assertRedirect(route('login'));
    }


}
