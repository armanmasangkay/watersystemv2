<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'username'=>'admin'
        ]);
        User::factory(1)->create([
            'username'=>'cashier',
            'role'=>User::$CASHIER
        ]);
        User::factory(1)->create([
            'username'=>'building',
            'role'=>User::$BLDG_INSPECTOR
        ]);
        User::factory(1)->create([
            'username'=>'reader',
            'role'=>User::$READER
        ]);
        User::factory(1)->create([
            'username'=>'waterworks',
            'role'=>User::$WATERWORKS_INSPECTOR
        ]);
        User::factory(1)->create([
            'username'=>'engineer',
            'role'=>User::$ENGINEER
        ]);
    }
}
