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

class LedgerTransactionTest extends TestCase
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
            'meter_serial_number'=>'123',
            'connection_type' => 'Residential',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
    }


    private function get_transaction($customer){
        return Transaction::where('customer_id', $customer->account_number)->latest()->first();
    }

    private function create_user_admin(){
        $user = User::factory()->create();
        return $user;
    }

    public function test_display_consumer_ledger_if_consumer_exist(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);

        Surcharge::factory()->create();
        $user = $this->create_user_admin();
        $this->create_customer_with_transaction();

        $customer = Customer::where('account_number', '!=', '')->first();

        $response = $this->actingAs($user)->get(route('admin.search-transactions',['account_number' => $customer->account_number]),[
            'account_number' => $customer->account_number
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertViewIs('pages.consumer-ledger');
        $response->assertViewHasAll(['customer', 'rates', 'surcharge', 'last_date', 'search_route', 'current_transaction_id']);

    }

    public function test_fail_if_consumer_account_number_is_invalid_or_consumer_doesnt_exist(){
        $user = $this->create_user_admin();
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();

        $response = $this->actingAs($user)->get(route('admin.search-transactions',['account_number' => '123211321']),[
            'account_number' =>'123211321'
        ]);


        $response->assertSessionHasErrors(['account_number.exists']);
        $response->assertRedirect(route('admin.consumer-ledger'));
    }

    public function test_success_adding_new_billing_transaction(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);

        Surcharge::factory()->create();
        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'current_transaction_id' => $recentTransaction->id,
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => 101,
            'amount' => 65,
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);


        $this->assertDatabaseCount('transactions',2);
        $response->assertJson(['created' => true]);
    }

    public function test_fail_if_adding_new_billing_transaction_missing_any_required_data(){
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);

        Surcharge::factory()->create();
        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'reading_date' => $date,
            'reading_meter' => 101,
            'amount' => 65,
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);


        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false]);
    }

    public function test_display_consumer_ledger_if_user_is_authenticated(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.consumer-ledger'));
        $response->assertViewIs('pages.consumer-ledger');
        $response->assertSeeText('No records to display');
    }

    public function test_reading_meter_should_not_allow_less_than_or_equal_to_zero()
    {
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();

        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'current_transaction_id' => $recentTransaction->id,
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => 0,
            'amount' => 65,
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);

        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false, 'msg' => array('reading_meter' => [])]);
    }

    public function test_amount_should_not_allow_less_than_or_equal_to_zero()
    {
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();

        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'current_transaction_id' => $recentTransaction->id,
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => 101,
            'amount' => 0,
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);


        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false, 'msg' => array('amount' => [])]);
    }

    public function test_total_should_not_allow_less_than_or_equal_to_zero()
    {
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();

        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'current_transaction_id' => $recentTransaction->id,
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => 101,
            'amount' => 65,
            'meter_ips' => '0.00',
            'total' => 0,
        ]);


        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false, 'msg' => array('total' => [])]);
    }

    public function test_recent_transaction_id_should_be_required_in_form_submit()
    {
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();

        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => 101,
            'amount' => 65,
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);


        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false, 'msg' => array('current_transaction_id' => [])]);
    }

    public function test_reading_meter_should_be_numeric()
    {
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();

        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'current_transaction_id' => $recentTransaction->id,
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => "sample",
            'amount' => 65,
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);


        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false, 'msg' => array('reading_meter' => [])]);
    }

    public function test_amount_should_be_numeric()
    {
        WaterRate::factory()->create();
        WaterRate::factory()->create(['type' => 'Commercial']);
        WaterRate::factory()->create(['type' => 'Institutional']);
        Surcharge::factory()->create();

        $this->create_customer_with_transaction();
        $user = $this->create_user_admin();
        $customer = Customer::where('account_number', '!=', '')->first();

        $recentTransaction = $this->get_transaction($customer);
        $surcharge = Surcharge::where('id', '!=', '')->first();
        $date = Carbon::now();
        $nextMonthDate = Carbon::now()->addMonth();


        $response = $this->actingAs($user)->post(route('admin.save-billing'),[
            'current_transaction_id' => $recentTransaction->id,
            'surcharge_amount' => $recentTransaction->billing_amount * $surcharge->rate,
            'customer_id' => $customer->account_number,
            'current_month' => $date->format('F'). ' '. $date->format('d'),
            'next_month' => $nextMonthDate->format('F') . ' '. $date->format('d'),
            'consumption' => 0.00,
            'reading_date' => $date,
            'reading_meter' => 65,
            'amount' => "sample",
            'meter_ips' => '0.00',
            'total' => 65 + ($recentTransaction->billing_amount * $surcharge->rate),
        ]);


        $this->assertDatabaseCount('transactions',1);
        $response->assertJson(['created' => false, 'msg' => array('amount' => [])]);
    }

}
