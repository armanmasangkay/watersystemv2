<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTransactionTest extends TestCase
{
    use RefreshDatabase;

    private function create_customer_with_transaction(){
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
            'meter_serial_number'=>'123',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
    }

    public function test_get_consumer_bill(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();
       
        $response = $this->post(route('admin.get-bill', ['id' =>$transaction->id]), ['customer_id' => $customer->account_number]);

        $response->assertJson(['getBill' => true]);
    }

    public function test_update_consumer_transaction(){
        Artisan::call('migrate --seed');
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->create_customer_with_transaction();
        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();

        $response = $this->post(route('admin.update-billing', ['id' => $customer->account_number]),[
            'edit_curr_transaction_id' => $transaction->id,
            'edit_reading_meter'=> $transaction->reading_meter,
            'current_meter' => 101,
            'edit_surcharge_amount' => 0,
            // dili  ko sure ani kay sige kog pangita sa ijang html element name wala juy billing total
            // peru sa ijang code naay $request->billing_total
            // palihug lamang kog remove ani inig merge na. Thank you :)
            'billing_total' => 0,
            'edit_total' => 975,
            'edit_amount' => 975,
            'edit_consumption' => 101,
            'edit_reading_date' => Carbon::now(),
            'edit_customer_id' => $customer->account_number,
        ]);

        $response->assertJson(['created' => true]);
    }
}
