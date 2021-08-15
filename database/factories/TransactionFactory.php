<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand_num = rand(100,105);
        return [
            'reading_meter' => rand(100,105),
            'balance' => $rand_num,
            'reading_date' => now(),
            'reading_consumption' =>0,
            'billing_amount' => $rand_num,
            'billing_surcharge' => 0,
            'billing_meter_ips' => $rand_num,
            'billing_total' => $rand_num,
            'balance' => $rand_num,
        ];
    }
}
