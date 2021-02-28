<?php

namespace Tests\Unit;

use App\Classes\Facades\FakeCustomerData;
use PHPUnit\Framework\TestCase;

class FakeCustomerDataTest extends TestCase
{
    public function test_all_fake_functions_returns_a_data_that_is_not_empty()
    {
       $civilStatus=FakeCustomerData::civilStatus();
       $type=FakeCustomerData::connectionType();
       $status=FakeCustomerData::connectionStatus();

       $allHasValue=$civilStatus && $type & $status?true:false;
       $this->assertTrue($allHasValue);
    }
}
