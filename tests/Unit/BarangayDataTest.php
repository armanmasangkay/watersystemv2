<?php

namespace Tests\Unit;

use App\Classes\Facades\BarangayData;
use App\Exceptions\BarangayDoesNotExistException;
use PHPUnit\Framework\TestCase;

class BarangayDataTest extends TestCase
{
    public function test_names_function_does_not_return_an_empty_array()
    {
        $values=BarangayData::names();
        $isEmpty=$values?false:true;

        $this->assertNotTrue($isEmpty);
        
    }

    public function test_function_getCodeByName_must_return_a_valid_code_given_an_existing_barangay()
    {
        $code=BarangayData::getCodeByName("Amparo");
        $this->assertEquals("020",$code);
    }

    public function test_function_getCodeByName_must_null_if_barangay_provided_does_not_exist()
    {
       
        $code=BarangayData::getCodeByName("Amparoxx");
        $isNull=$code===null?true:false;
        $this->assertTrue($isNull);
       
    }

    public function test_function_getRandomBarangayName_returns_some_data_that_is_not_empty()
    {
        $barangay=BarangayData::getRandomBarangayName();
        $hasValue=!empty($barangay);

        $this->assertTrue($hasValue);
    }

 


}
