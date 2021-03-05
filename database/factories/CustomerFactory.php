<?php

namespace Database\Factories;

use App\Classes\Facades\AccountNumber;
use App\Classes\Facades\BarangayData;
use App\Classes\Facades\FakeCustomerData;
use App\Exceptions\BarangayDoesNotExistException;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Stringable;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    protected $counter=1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currentYear=date("Y");
        $customerData=[ 
            'account_number'=>"020-$currentYear-".str_pad($this->counter++,3,'0',STR_PAD_LEFT),
            'firstname'=>$this->faker->firstName,
            'middlename'=>$this->faker->lastName,
            'lastname'=>$this->faker->lastName,
            'civil_status'=>FakeCustomerData::civilStatus(),
            'purok'=>'Purok 1',
            'barangay'=>'Amparo',
            'contact_number'=>'09757375747',
            'connection_type'=>FakeCustomerData::connectionType(),
            'connection_status'=>FakeCustomerData::connectionStatus()
        ];
        return $customerData;
      
        
    }
}
