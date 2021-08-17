<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Models\Surcharge;
use App\Models\Transaction;
use App\Models\WaterRate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private function create_customer_with_transaction(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $date = Carbon::now();
        $this->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
    }

    public function test_get_consumer_balance()
    {
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $response = $this->post(route('admin.get-balance', ['id' => $customer->account_number]));

        $response->assertJson(['getBalance' => true]);
    }

    public function test_save_consumer_payment()
    {
        Artisan::call('migrate --seed');
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();

        $orNum = Str::random(8);
        $response = $this->post(route('admin.save-payment', ['id' => $customer->account_number]),[
            'orNum' => $orNum,
            'inputedAmount' => 101,
            'totalAmount' => $transaction->billing_total,
            'curr_transaction_id' => $transaction->id,
            'payment_date' => now()
        ]);

        $response->assertJson(['created' => true]);
    }

    public function test_or_num_should_be_required(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();

        $orNum = Str::random(8);
        $response = $this->post(route('admin.save-payment', ['id' => $customer->account_number]),[
            'inputedAmount' => 101,
            'totalAmount' => $transaction->billing_total,
            'curr_transaction_id' => $transaction->id,
            'payment_date' => now()
        ]);

        $response->assertJson(['created' => false, 'errors' => ["orNum" => []]]);
    }

    public function test_inputed_amount_should_be_required(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();

        $orNum = Str::random(8);
        $response = $this->post(route('admin.save-payment', ['id' => $customer->account_number]),[
            'orNum' => $orNum,
            'totalAmount' => $transaction->billing_total,
            'curr_transaction_id' => $transaction->id,
            'payment_date' => now()
        ]);

        $response->assertJson(['created' => false, 'errors' => ["inputedAmount" => []]]);
    }

    public function test_inputed_amount_should_be_numeric(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();

        $orNum = Str::random(8);
        $response = $this->post(route('admin.save-payment', ['id' => $customer->account_number]),[
            'orNum' => $orNum,
            'inputed_amount' => 'sample',
            'totalAmount' => $transaction->billing_total,
            'curr_transaction_id' => $transaction->id,
            'payment_date' => now()
        ]);

        $response->assertJson(['created' => false, 'errors' => ["inputedAmount" => []]]);
    }

    public function test_inputed_amount_should_be_greater_than_or_not_equal_to_zero(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();

        $orNum = Str::random(8);
        $response = $this->post(route('admin.save-payment', ['id' => $customer->account_number]),[
            'orNum' => $orNum,
            'inputed_amount' => 0,
            'totalAmount' => $transaction->billing_total,
            'curr_transaction_id' => $transaction->id,
            'payment_date' => now()
        ]);

        $response->assertJson(['created' => false, 'errors' => ["inputedAmount" => []]]);
    }
}
