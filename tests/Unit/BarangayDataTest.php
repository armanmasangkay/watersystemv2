<?php

namespace Tests\Unit;

use App\Classes\Facades\BarangayData;
use PHPUnit\Framework\TestCase;

class BarangayDataTest extends TestCase
{
    public function test_names_function_does_not_return_an_empty_array()
    {
        $values=BarangayData::names();
        $isEmpty=$values?false:true;

        $this->assertNotTrue($isEmpty);
        
    }

}
