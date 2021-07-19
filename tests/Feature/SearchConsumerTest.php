<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SearchConsumerTest extends TestCase
{
    use RefreshDatabase;


    //TODO: Fix this
    public function test_should_redirect_back_with_errors_when_keyword_is_not_supplied()
    {
        $user=User::factory()->create();


        $response=$this->actingAs($user)
                       ->get(route('admin.searched-customers.index'));
        $response->assertRedirect(route('admin.searched-customers.index'))
                 ->assertSessionHasErrors('keyword');

    }
}
