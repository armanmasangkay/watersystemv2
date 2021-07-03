<?php

namespace Database\Seeders;

use App\Models\Surcharge;
use Illuminate\Database\Seeder;

class SurchargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Surcharge::create([
            'rate' => '0.1'
        ]);
    }
}
