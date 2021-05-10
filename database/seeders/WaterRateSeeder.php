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
        $names = ['Residential', 'Institutional', 'Commercial'];
        for($x = 0 ; $x < 3 ; $x++)
        {
            WaterRate::factory()->create([
                'type' => $names[$x],
            ]);
        }
    }
}
