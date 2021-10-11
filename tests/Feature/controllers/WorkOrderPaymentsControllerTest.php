<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use App\Models\PaymentWorkOrder;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkOrderPaymentsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renders_the_payments_list_propery()
    {
        $user= User::factory()->create();

        $customer=Customer::factory()->create();

        $service=Service::factory()->create([
            'customer_id'=>$customer->account_number
        ]);

    
        $payments=PaymentWorkOrder::factory()->count(5)->create([
            'service_id'=>$service->id,
            'customer_id'=>$customer->account_number,
            'user_id'=>$user->id
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertViewIs('pages.work-order-payments')
                ->assertViewHas('payments');
    
        $this->assertEquals($payments->pluck('id')->toArray(),$response['payments']->pluck('id')->toArray());
        $this->assertInstanceOf(Paginator::class,$response['payments']);
    
    }


    public function test_it_can_be_accessed_by_cashier()
    {
        $user= User::factory()->create([
            'role'=>User::$CASHIER
        ]);

        $customer=Customer::factory()->create();

        $service=Service::factory()->create([
            'customer_id'=>$customer->account_number
        ]);

    
        $payments=PaymentWorkOrder::factory()->count(5)->create([
            'service_id'=>$service->id,
            'customer_id'=>$customer->account_number,
            'user_id'=>$user->id
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertViewIs('pages.work-order-payments')
                ->assertViewHas('payments');
    
        $this->assertEquals($payments->pluck('id')->toArray(),$response['payments']->pluck('id')->toArray());

    }

    public function test_it_cannot_be_accessed_by_reader()
    {
        $user= User::factory()->create([
            'role'=>User::$READER
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertForbidden();

    }

    public function test_it_cannot_be_accessed_by_engieer()
    {
        $user= User::factory()->create([
            'role'=>User::$ENGINEER
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertForbidden();

    }

    public function test_it_cannot_be_accessed_by_waterworks()
    {
        $user= User::factory()->create([
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertForbidden();

    }

    public function test_it_cannot_be_accessed_by_building_inspector()
    {
        $user= User::factory()->create([
            'role'=>User::$BLDG_INSPECTOR
        ]);

        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertForbidden();

    }

    public function test_it_renders_the_payments_list_propery_with_the_latest_at_the_top()
    {
        $user= User::factory()->create();

        $customer=Customer::factory()->create();

        $service=Service::factory()->create([
            'customer_id'=>$customer->account_number
        ]);

    
        $payments=PaymentWorkOrder::factory()->createMany([
            [
            'id'=>1,
            'service_id'=>$service->id,
            'customer_id'=>$customer->account_number,
            'user_id'=>$user->id,
            'updated_at'=>now()
            ],
            [
            'id'=>2,
            'service_id'=>$service->id,
            'customer_id'=>$customer->account_number,
            'user_id'=>$user->id,
            'updated_at'=>now()->addMinutes(2)
            ],
            [
            'id'=>3,
            'service_id'=>$service->id,
            'customer_id'=>$customer->account_number,
            'user_id'=>$user->id,
            'updated_at'=>now()->addMinutes(4)
            ]
        ]);

       
        $this->actingAs($user);

        $response=$this->get(route('admin.work-order.payments.index'));

        $response->assertViewIs('pages.work-order-payments')
                ->assertViewHas('payments');
    
    
        $this->assertEquals([3,2,1],$response['payments']->pluck('id')->toArray());
    
    
    }
}
