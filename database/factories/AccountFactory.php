<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_number'=>Customer::factory()->create()->account_number,
            'email'=>$this->faker->email(),
            'mobile_number'=>$this->faker->phoneNumber(),
            'password'=>Hash::make('1234'),
            'valid_id'=>$this->faker->sentence(),
            'latest_bill'=>$this->faker->sentence(),
            'other_party'=>null,
            'status'=>Account::STATUS_ACTIVE
        ];
    }
}
