<?php

namespace Database\Factories;

use App\Models\WaterRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaterRateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $waterRate = WaterRate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'=>'Residential',
            'consumption_max_range' => 10,
            'min_rate' => 65,
            'excess_rate' => 10,
        ];

    }
}
