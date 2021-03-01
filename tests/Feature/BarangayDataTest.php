<?php

namespace Tests\Feature;

use App\Classes\Facades\BarangayData;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BarangayDataTest extends TestCase
{
    use RefreshDatabase;
    public function test_function_numberOfPeopleOn_should_return_correct_number_of_people()
    {
        Customer::factory()->count(2)->create([
            'barangay'=>'Amparo'
        ]);

        $numberOfPeopleRegistered=BarangayData::numberOfPeopleOn("Amparo");
        $this->assertEquals(2,$numberOfPeopleRegistered);
    

    }
}
