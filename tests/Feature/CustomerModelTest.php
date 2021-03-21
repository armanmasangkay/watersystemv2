<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerModelTest extends TestCase
{
    use RefreshDatabase;
   public function test_fullname_function_returns_proper_full_name()
   {
        $customer=Customer::factory()->create([
            'firstname'=>'Arman',
            'lastname'=>'Masangkay'
        ]);
        $customerFullname=$customer->fullname();
        $this->assertEquals('Arman Masangkay',$customerFullname);
   }

   public function test_fullname_function_returns_proper_full_name_with_improper_casing()
   {
        $customer=Customer::factory()->create([
            'firstname'=>'arman',
            'lastname'=>'MaSangkay'
        ]);

        $customerFullname=$customer->fullname();
        $isNameEqual=$customerFullname === "Arman Masangkay";
       $this->assertTrue($isNameEqual);
   }

   public function test_address_funtion_returns_proper_address()
   {
    $customer=Customer::factory()->create([
        'purok'=>'Taliwa',
        'barangay'=>'Meowk'
    ]);
    $this->assertEquals('Taliwa, Meowk',$customer->address());

   }
}
