<?php

namespace Tests\Controllers\Feature;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class EditBillingControllerTest extends TestCase
{
    use RefreshDatabase;
    private function create_customer_with_transaction($user){
        $date = Carbon::now();
        $this->actingAs($user)->post(route('admin.register-customer.store'),[
            'firstname' => "June Vic",
            'middlename' => '',
            'lastname' => 'Cadayona',
            'civil_status' => 'single',
            'purok' => 'Somewhere',
            'barangay' => 'Somewhere',
            'contact_number' => '09178781045',
            'connection_type' => 'Residential',
            'meter_serial_number'=>'12344',
            'connection_status' => 'Active',
            'purchase_option' => 'cash',
            'reading_meter' => '100',
            'balance' => '100',
            'reading_date' => $date->toDateString(),
            'billing_meter_ips' => '100'
        ]);
    }
    
    public function test_update_consumer_transaction(){
        Artisan::call('migrate --seed');
        $user = User::factory()->create();
        $this->create_customer_with_transaction($user);

        $customer = Customer::where('account_number', '!=', '')->first();
        $transaction = Transaction::where('id', '!=', '')->first();
        $response = $this->actingAs($user)->post(route('admin.update-billing', ['id' => $customer->account_number]),[
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
