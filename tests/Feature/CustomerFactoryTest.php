<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerFactoryTest extends TestCase
{

    use RefreshDatabase;
   public function test_customer_factory_can_create_a_customer()
   {
       $customer=Customer::factory()->create();
       $isCreated=$customer?true:false;
       $this->assertTrue($isCreated);
   }

   public function test_customer_factory_can_create_100_customers()
   {

        $customer=Customer::factory()->count(100)->create();
        $count=count($customer);
        $this->assertEquals(100,$count);
   }

   public function test_customer_factor_create_a_customer_with_correct_account_format()
   {
        $currentYear=date("Y");
        $customer=Customer::factory()->create(); 
        $this->assertEquals("020-$currentYear-001",$customer->account_number);
   }


}
