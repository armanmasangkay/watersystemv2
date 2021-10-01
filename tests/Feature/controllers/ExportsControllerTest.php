<?php

namespace Tests\Controllers\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExportsControllerTest extends TestCase
{
   use RefreshDatabase;
   private function clean()
   {
       (new Filesystem)->cleanDirectory('storage/framework/laravel-excel');
   }

   //Customer Export Assertions
   public function test_customers_export_route()
   {
       $user=User::factory()->create();
      $response=$this->actingAs($user)->get(route('admin.customers.export'));
      $response->assertOk();
      $this->clean();
   }

   public function test_customers_export_is_available_only_for_logged_in_users()
   {
   
      $response=$this->get(route('admin.customers.export'));
      $response->assertRedirect();

   }

   public function test_customers_export_route_with_keyword()
   {
       $user=User::factory()->create();
      $response=$this->actingAs($user)->get(route('admin.customers.export',['keyword'=>'arman']));
      $response->assertOk();
      $this->clean();
   }

   public function test_user_can_download_customers_export_without_keyword_supplied() 
   {
       Excel::fake();
       $user=User::factory()->create();
       $this->actingAs($user)
           ->get(route('admin.customers.export'));
       Excel::assertDownloaded('customers.xlsx');
   }
   public function test_user_can_download_customers_export_with_keyword_supplied() 
   {
       Excel::fake();
       $user=User::factory()->create();
       $this->actingAs($user)
           ->get(route('admin.customers.export',['keyword'=>'arman']));
       Excel::assertDownloaded('arman.xlsx');
   }

   //Ledger Export Assertions

   public function test_ledger_export_route()
   {
       $user=User::factory()->create();
       $customer=Customer::factory()->create();
      $response=$this->actingAs($user)->get(route('admin.ledger.export',['account_number'=>$customer->account_number]));
      $response->assertOk();
      $this->clean();
   }

   public function test_ledger_export_is_available_only_for_logged_in_users()
   {
   
      $response=$this->get(route('admin.ledger.export',['account_number'=>'testnumber']));
      $response->assertRedirect();
   }

   public function test_user_can_download_ledger_export() 
   {
       Excel::fake();
       $user=User::factory()->create();
       $this->actingAs($user)
           ->get(route('admin.ledger.export',['account_number'=>'testing']));
       Excel::assertDownloaded('testing ledger.xlsx');
   }
}
