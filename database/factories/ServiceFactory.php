<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id'=>'1',
            'type_of_service'=>'reconnection',
            'request_number'=>uniqid(),
            'remarks'=>'No remarks',
            'landmarks'=>'Near Bulwagan',
            'work_schedule'=>now(),
            'status'=>Service::$PENDING_BUILDING_INSPECTION,
            'start_status'=>Service::$PENDING_BUILDING_INSPECTION,
        ];
    }
}
