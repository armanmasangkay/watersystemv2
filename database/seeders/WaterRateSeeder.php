<?php

namespace Database\Seeders;

use App\Models\WaterRate;
use Illuminate\Database\Seeder;

class WaterRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Residential', 'Institutional'];
        for($x = 0 ; $x < 2 ; $x++)
        {
            WaterRate::factory()->create([
                'type' => $names[$x],
            ]);
        }

        WaterRate::create([
            'type' => 'Commercial',
            'consumption_max_range' => 10,
            'min_rate' => 1.1,
            'excess_rate' => 0.15,
        ]);
    }
}
