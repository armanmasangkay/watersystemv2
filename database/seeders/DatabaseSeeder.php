<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_DEBUG') == true){
            $this->call([
                UserSeeder::class,
                CustomerSeeder::class,
                WaterRateSeeder::class,
                SurchargeSeeder::class,
                ServicesListSeeder::class,
            ]);
        }else{
            $this->call([
                UserSeeder::class,
                WaterRateSeeder::class,
                SurchargeSeeder::class,
            ]);
        }


    }
}
