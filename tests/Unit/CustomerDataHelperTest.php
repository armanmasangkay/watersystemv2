<?php

namespace Tests\Unit;

use App\Classes\Facades\CustomerDataHelper;
use App\Exceptions\ExpectedKeyNotFoundException;
use PHPUnit\Framework\TestCase;

class CustomerDataHelperTest extends TestCase
{
    public function test_normalize_function_returns_correct_formated_data()
    {
        $data=[
            'firstname'=>'arman',
            'middlename'=>'macasuhot',
            'lastname'=>'masangkay',
            'purok'=>'purok 1'
        ];
        $normalizedData=CustomerDataHelper::normalize($data);
        $this->assertEquals("Arman",$normalizedData['firstname']);
        $this->assertEquals("Macasuhot",$normalizedData['middlename']);
        $this->assertEquals("Masangkay",$normalizedData['lastname']);
        $this->assertEquals("Purok 1",$normalizedData['purok']);
    }

    public function test_normalize_function_to_throw_exception_when_firstname_key_is_not_found()
    {

        $this->expectException(ExpectedKeyNotFoundException::class);
        $data=[
            'middlename'=>'macasuhot',
            'lastname'=>'masangkay',
            'purok'=>'purok 1'
        ];
        CustomerDataHelper::normalize($data);

    }
    public function test_normalize_function_to_throw_exception_when_middlename_key_is_not_found()
    {

        $this->expectException(ExpectedKeyNotFoundException::class);
        $data=[
            'firstname'=>'arman',
            'lastname'=>'masangkay',
            'purok'=>'purok 1'
        ];
        CustomerDataHelper::normalize($data);

    }
    public function test_normalize_function_to_throw_exception_when_lastname_key_is_not_found()
    {

        $this->expectException(ExpectedKeyNotFoundException::class);
        $data=[
            'firstname'=>'arman',
            'middlename'=>'macasuhot',
            'purok'=>'purok 1'
        ];
        CustomerDataHelper::normalize($data);

    }

    public function test_normalize_function_to_throw_exception_when_purok_key_is_not_found()
    {

        $this->expectException(ExpectedKeyNotFoundException::class);
        $data=[
            'firstname'=>'arman',
            'middlename'=>'macasuhot',
            'lastname'=>'masangkay' 
        ];
        CustomerDataHelper::normalize($data);

    }

    public function test_normalize_function_to_normalize_even_blank_middlename()
    {
        $data=[
            'firstname'=>'arman',
            'middlename'=>'',
            'lastname'=>'masangkay',
            'purok'=>'purok 1'
        ];


        $normalized=CustomerDataHelper::normalize($data);

        $this->assertIsArray($normalized);

    }

    public function test_normalize_function_when_inputted_data_are_uppercased()
    {
        $data=[
            'firstname'=>'ARMAN',
            'middlename'=>'MACASUHOT',
            'lastname'=>'MASANGKAY',
            'purok'=>'PUROK 1'
        ];
        $normalized=CustomerDataHelper::normalize($data);
        $this->assertEquals('Arman',$normalized['firstname']);
        $this->assertEquals('Macasuhot',$normalized['middlename']);
        $this->assertEquals('Masangkay',$normalized['lastname']);
        $this->assertEquals('Purok 1',$normalized['purok']);

    }

    public function test_normalize_function_when_inputted_data_are_mixed_cased()
    {
        $data=[
            'firstname'=>'aRMaN',
            'middlename'=>'MaCasuHoT',
            'lastname'=>'MaSaNgKay',
            'purok'=>'PuRok 1'
        ];
        $normalized=CustomerDataHelper::normalize($data);
        $this->assertEquals('Arman',$normalized['firstname']);
        $this->assertEquals('Macasuhot',$normalized['middlename']);
        $this->assertEquals('Masangkay',$normalized['lastname']);
        $this->assertEquals('Purok 1',$normalized['purok']);

    }

    public function test_normalize_function_to_properly_normalize_names_with_two_separate_names()
    {
        $data=[
            'firstname'=>'arman john',
            'middlename'=>'de gracia',
            'lastname'=>'de gracia',
            'purok'=>'purok john 1'
        ];
        $normalized=CustomerDataHelper::normalize($data);
        $this->assertEquals('Arman John',$normalized['firstname']);
        $this->assertEquals('De Gracia',$normalized['middlename']);
        $this->assertEquals('De Gracia',$normalized['lastname']);
        $this->assertEquals('Purok John 1',$normalized['purok']);
    }

 
}
