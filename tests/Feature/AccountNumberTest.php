<?php

namespace Tests\Feature;

use App\Classes\Facades\AccountNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountNumberTest extends TestCase
{
    public function test_can_generate_correct_format_account_number()
    {
        $numberOfRegisteredPeopleOnThatBarangay=0;
        $yearToday=date("Y");
        $firstAccountNumberGenerated=AccountNumber::new("020", $numberOfRegisteredPeopleOnThatBarangay);
        $numberOfRegisteredPeopleOnThatBarangay=2;
        $secondAccountNumberGenerated=AccountNumber::new("020",$numberOfRegisteredPeopleOnThatBarangay);
        $this->assertEquals("020-$yearToday-001",$firstAccountNumberGenerated);
        $this->assertEquals("020-$yearToday-003",$secondAccountNumberGenerated);  
    }
}
