<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterServicesByRangeOfDateTest extends TestCase
{
    use RefreshDatabase;


  public function test_can_be_filtered_by_date()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now()->subDays(1)->format("Y-m-d"),
          'to'=>now()->format("Y-m-d"),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
        ->assertViewIs('pages.services-list')
        ->assertViewHas([
            'status',
            'services'
        ]);

    $responseServices=$response['services'];
    $this->assertEquals($services[2]->id,$responseServices[0]->id);
    $this->assertEquals($services[3]->id,$responseServices[1]->id);
  }

  public function test_successful_filtering_should_return_inputted_from_and_to_dates()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now()->subDays(1)->format("Y-m-d"),
          'to'=>now()->format("Y-m-d"),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
        ->assertViewIs('pages.services-list')
        ->assertViewHas([
            'status',
            'services',
            'from'=>now()->subDays(1)->format("Y-m-d"),
            'to'=>now()->format("Y-m-d")
            
        ]);

    $responseServices=$response['services'];
    $this->assertEquals($services[2]->id,$responseServices[0]->id);
    $this->assertEquals($services[3]->id,$responseServices[1]->id);
  }


  public function test_filter_by_date_is_only_required_if_either_of_two_values_are_supplied()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>'',
          'to'=>'',
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
        ->assertViewIs('pages.services-list')
        ->assertViewHas([
            'status',
            'services'
        ]);

    $responseServices=$response['services'];
    $this->assertEquals($services[0]->id,$responseServices[0]->id);
    $this->assertEquals($services[1]->id,$responseServices[1]->id);
    $this->assertEquals($services[2]->id,$responseServices[2]->id);
    $this->assertEquals($services[3]->id,$responseServices[3]->id);
  }

  public function test_should_still_filter_even_range_of_date_is_not_provided_and_will_just_display_services_based_on_filter()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
        ->assertViewIs('pages.services-list')
        ->assertViewHas([
            'status',
            'services'
        ]);

    $responseServices=$response['services'];
    $this->assertEquals($services->pluck('id')->toArray(),$responseServices->pluck('id')->toArray());

  }
  public function test_should_produce_an_error_if_fromdate_has_value_and_todate_do_not()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now()->subDays(1)->format("Y-m-d"),
          'to'=>'',
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
            ->assertRedirect(route('admin.services.index',[
                'filter'=>Service::$PENDING_BUILDING_INSPECTION
            ]))
            ->assertSessionHasErrors(['to']);
    

  }
  public function test_should_produce_an_error_if_todate_has_value_and_fromdate_do_not()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>'',
          'to'=>now()->toDateString(),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
            ->assertRedirect(route('admin.services.index',[
                'filter'=>Service::$PENDING_BUILDING_INSPECTION
            ]))
            ->assertSessionHasErrors(['from']);

  }

  public function test_should_produce_an_error_if_fromdate_is_greater_than_todate()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now()->addDays(2)->toDateString(),
          'to'=>now()->toDateString(),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
            ->assertRedirect(route('admin.services.index',[
                'filter'=>Service::$PENDING_BUILDING_INSPECTION
            ]))
            ->assertSessionHasErrors(['from']);

  }

  public function test_should_not_produce_an_error_if_fromdate_is_equal_to_todate()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now(),
          'to'=>now(),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response->assertOk();

  }

  public function test_should_return_inputted_date_if_filtering_failed()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now()->subDays(1)->format("Y-m-d"),
          'to'=>now()->subDays(2)->format("Y-m-d"),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
            ->assertRedirect(route('admin.services.index',[
                'filter'=>Service::$PENDING_BUILDING_INSPECTION
            ]))
            ->assertSessionHasAll([
                'from'=>now()->subDays(1)->format("Y-m-d"),
                'to'=>now()->subDays(2)->format("Y-m-d"),
            ]);
    

  }

  public function test_filter_parameter_should_be_on_URL_if_filtering_failed()
  {
      $user=User::factory()->create();
      $this->actingAs($user);

      $customer=Customer::factory()->create();

      $services=Service::factory()->createMany([
          [
              'customer_id'=>$customer->account_number,
              'created_at'=>now()->subDays(3)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(2)
          ],
          [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()->subDays(1)
        ],
        [
            'customer_id'=>$customer->account_number,
            'created_at'=>now()
        ],
    ]);

      $response=$this->get(route('admin.services.filter',[
          'from'=>now()->subDays(1)->format("Y-m-d"),
          'to'=>now()->subDays(2)->format("Y-m-d"),
          'filter'=>Service::$PENDING_BUILDING_INSPECTION
      ]));

      $response
            ->assertRedirect(route('admin.services.index',[
                'filter'=>Service::$PENDING_BUILDING_INSPECTION
            ]))
            ->assertSessionHasAll([
                'from'=>now()->subDays(1)->format("Y-m-d"),
                'to'=>now()->subDays(2)->format("Y-m-d"),
            ]);

  }
}
