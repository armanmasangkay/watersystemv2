<?php

namespace Database\Factories;

use App\Models\PaymentWorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentWorkOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentWorkOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id'=>'',
            'customer_id'=>'',
            'or_no'=>uniqid(),
            'payment_amount'=>$this->faker->randomFloat(),
            'user_id'=>'',
        ];
    }
}
