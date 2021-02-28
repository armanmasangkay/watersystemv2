<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BarangayDataTest extends TestCase
{
    use RefreshDatabase;
    public function test_function_numberOfPeopleOn_should_return_correct_number_of_people()
    {
        Customer::factory()->create([
            'barangay'=>'Amparo'
        ]);

        $numberOfPeopleRegistered=Customer::where('barangay','Amparo')->count();
        $this->assertEquals(1,$numberOfPeopleRegistered);
    

    }
}
