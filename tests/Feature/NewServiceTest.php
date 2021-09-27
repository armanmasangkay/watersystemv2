<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use App\Services\Testing\RoleAccessService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewServiceTest extends TestCase
{
    use RefreshDatabase;

    private $accessService;

    public function setUp():void
    {
        parent::setUp();
        $this->accessService=new RoleAccessService($this);
    }


    public function test_index_route()
    {
        $user=User::factory()->create(); 
        $response=$this->actingAs($user)->get(route('admin.services.index'));
        $response->assertViewIs('pages.services-list');
        $response->assertViewHasAll([
            'services',
            'status'
        ]);
    }

    public function test_index_route_accessible_to_admin_only()
    {
        $this->accessService->forAdminOnlyGet(route('admin.services.index'));
        // $user=User::factory()->create();
        // $response=$this->actingAs($user)->get(route('admin.services.index')); 
        // $response->assertOk();

        // $user=User::factory()->create([
        //     'role'=>User::$CASHIER
        // ]);
        // $response=$this->actingAs($user)->get(route('admin.services.index')); 
        // $response->assertForbidden();

        // $user=User::factory()->create([
        //     'role'=>User::$BLDG_INSPECTOR
        // ]);
        // $response=$this->actingAs($user)->get(route('admin.services.index')); 
        // $response->assertForbidden();

        // $user=User::factory()->create([
        //     'role'=>User::$WATERWORKS_INSPECTOR
        // ]);
        // $response=$this->actingAs($user)->get(route('admin.services.index')); 
        // $response->assertForbidden();

        // $user=User::factory()->create([
        //     'role'=>User::$READER
        // ]);
        // $response=$this->actingAs($user)->get(route('admin.services.index')); 
        // $response->assertForbidden();

        // $user=User::factory()->create([
        //     'role'=>User::$ENGINEER
        // ]);
        // $response=$this->actingAs($user)->get(route('admin.services.index')); 
        // $response->assertForbidden();


    }


    public function test_filter_route()
    {
        $user=User::factory()->create(); 
        $response=$this->actingAs($user)->get(route('admin.services.filter'));
        $response->content();
        $response->assertViewIs('pages.services-list');
        
        $response->assertViewHasAll([
            'services',
            'status'
        ]);

         //TODO: work with this test
    }

    public function test_filter_route_is_accessible_only_to_admin()
    {

    }
  
}
