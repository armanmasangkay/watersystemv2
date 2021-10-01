<?php

namespace Tests\Controllers\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchedCustomerControllerTest extends TestCase
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
                       ->get(route('admin.searched-customers.index',['keyword'=>'Arman']));

        $response->assertViewIs('pages.customers-list');
        $response->assertViewHas(['keyword'=>'Arman']);
    }

    public function test_search_customer_uri_is_not_accessible_to_unauthenticated_user()
    {
        $user=User::factory()->create();
        $response=$this->get(route('admin.searched-customers.index').'?keyword=Arman'); 
        $response->assertRedirect(route('login'));
    }

    public function test_should_show_show_all_button_after_searching()
    {
        $user=User::factory()->create();
    
        $response=$this->actingAs($user)
                       ->get(route('admin.searched-customers.index',['keyword'=>'Arman']));
        $response->assertSeeText('Show all');
    }

    public function test_should_show_no_records_to_display_when_no_customer_in_database()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)
                       ->get(route('admin.searched-customers.index',['keyword'=>'Arman']));
        $response->assertSeeText('No records to display');
    }

    public function test_no_records_to_display_text_should_not_be_displayed_if_there_is_a_customer_in_the_database()
    {
        $user=User::factory()->create();
        Customer::factory()->create();
        $response=$this->actingAs($user)
                       ->get(route('admin.existing-customers.index'));

        $response->assertDontSeeText('No records to display');
    }
}
