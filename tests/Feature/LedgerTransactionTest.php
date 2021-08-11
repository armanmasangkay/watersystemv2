<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Surcharge;
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


    public function test_display_consumer_ledger(){
        Artisan::call('migrate --seed');
        $user = $this->create_user_admin();
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();

        $response = $this->actingAs($user)->get(route('admin.search-transactions',['account_number' => $customer->account_number]),[
            'account_number' => $customer->account_number
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertViewIs('pages.consumer-ledger');
        $response->assertViewHasAll(['customer', 'rates', 'surcharge', 'last_date', 'route', 'current_transaction_id']);

    }

    public function test_fail_if_consumer_account_number_is_invalid_or_consumer_doesnt_exist(){
        Artisan::call('migrate --seed');
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
        Artisan::call('migrate --seed');
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
        Artisan::call('migrate --seed');
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

}
