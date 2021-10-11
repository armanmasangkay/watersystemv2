<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    public function test_admin_should_see_work_order_payments_option()
    {
        $user=User::factory()->create();

        $this->actingAs($user);

        $response=$this->get(route('admin.dashboard'));

        $response->assertSeeText('Work Order Payments');
    }

    public function test_cashier_should_see_work_order_payments_link()
    {
        $user=User::factory()->create([
            'role'=>User::$CASHIER
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.existing-customers.index'));

        $response->assertSeeText('Work Order Payments');
    }

    public function test_reader_should_not_see_work_order_payments_link()
    {
        $user=User::factory()->create([
            'role'=>User::$READER
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.home'));

        $response->assertDontSeeText('Work Order Payments');
    }

    public function test_engineer_should_not_see_work_order_payments_link()
    {
        $user=User::factory()->create([
            'role'=>User::$ENGINEER
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.municipal-engineer.index'));

        $response->assertDontSeeText('Work Order Payments');
    }

    public function test_waterworks_inspector_should_not_see_work_order_payments_link()
    {
        $user=User::factory()->create([
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.waterworks-request-approvals'));

        $response->assertDontSeeText('Work Order Payments');
    }

    public function test_building_inspector_should_not_see_work_order_payments_link()
    {
        $user=User::factory()->create([
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.request-approvals'));

        $response->assertDontSeeText('Work Order Payments');
    }
}
