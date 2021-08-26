<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::factory()->create();

        Service::factory()->create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'contact_number' => $customer->contact_number,
            'status' => 'pending_building_inspection'
        ]);
    }
}
