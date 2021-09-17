<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Surcharge;
use App\Models\WaterRate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;
use App\Services\AccountNumberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldMeterReadingTest extends TestCase
{
    use RefreshDatabase;

    private function getUser()
    {
        return $user = User::factory()->create([
            'role'=>User::$READER
        ]);
    }
    public function test_can_search_consumer_with_transactions()
    {
        $customer = Customer::factory()->create([
            'connection_type'=>'Residential'
        ]);
       $user=$this->getUser();
      
        WaterRate::factory()->create();
        Surcharge::factory()->create();

        $transaction = Transaction::factory()->create([
            'customer_id' => $customer->account_number,
            'user_id' => $user->id,
            'posted_by' => $user->id
        ]);
        $response = $this->actingAs($user)->get(route('admin.reader.search',['account_number'=>$transaction->customer_id]));
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('field-personnel.pages.meter-reading');
        $response->assertViewHasAll(['customer', 'rates', 'surcharge', 'last_date', 'current_transaction_id']);
    }


    public function test_cannot_search_transaction_if_account_number_is_null()
    {
    
        $response = $this->actingAs($this->getUser())->get(route('admin.reader.search',['account_number'=>'']));
        $response->assertSessionHasErrors();
    }

    public function test_cannot_save_billing_if_current_meter_is_less_than_previous_meter_reading()
    {
        $response = $this->actingAs($this->getUser())->post(route('admin.save-meter-billing', ['reading_meter' => 99, 'meter_reading' => 100]));
        $response->assertStatus(200)
                    ->assertJson([
                        'created' => false,
                    ]);
    }

    public function test_cannot_update_previous_bill_surcharge_and_balance_if_null_transaction_id()
    {
        $response = $this->actingAs($this->getUser())->post(route('admin.save-meter-billing',['current_transaction_id' => '']));
        $response->assertStatus(404);
    }

    public function test_save_billing()
    {
        $customer = Customer::factory()->create([
            'connection_type'=>'Residential'
        ]);
        $user = User::factory()->create();
        WaterRate::factory()->create();
        Surcharge::create([
            'rate'=>'0.10'
        ]);

        $transaction = Transaction::factory()->create([
            'customer_id' => $customer->account_number,
            'user_id' => $user->id,
            'posted_by' => $user->id
        ]);

        $response = $this->actingAs($this->getUser())->post(route('admin.save-meter-billing',[
            'reading_meter' => 107,
            'customer_id' => $customer->account_number,
            'current_month' => 'Aug 09',
            'next_month' => 'Sept 09, 2021',
            'reading_date' => date('Y-m-d', strtotime("today")),
            'consumption' => 7.00,
            'amount' => 65.00,
            'surcharge_amount' => 0.00,
            'meter_ips' => 0.00,
            'total' => 65.00,
            'balance' => 65.00,
            'id' => $user->id,
            'id' => $user->id,
            'current_transaction_id' => $transaction->id,
            'payment_or_no' => '',
            'payment_date' => null,
            'surcharge_amount' => 6.5,
        ]));

        $response->assertJson([
                        'created' => true,
                    ]);
    }
}
