<?php namespace App\Services\Testing;

use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;
class RoleAccessService{


    private $testCase;
    public function __construct(TestCase $testCase)
    {
        $this->testCase=$testCase;
    
        
    }

    private function roles()
    {
        return User::validRoles();
    }

    public function accessibleOnlyTo(array $allowedRoles,$method,$route,$parameters=[])
    {
        $notAllowedRoles=Arr::except($this->roles(),$allowedRoles);

        foreach ($notAllowedRoles as $index=>$role){

            $user=User::factory()->create([
                'role'=>$index
            ]);

            $this->testCase->actingAs($user);

            $response=$this->testCase->call($method,$route,$parameters);

            $response->assertForbidden();
        }

        foreach ($allowedRoles as $index=>$role){

            $user=User::factory()->create([
                'role'=>$role
            ]);

            $this->testCase->actingAs($user);

            $response=$this->testCase->call($method,$route,$parameters);

            $response->assertOk();
        }

        
    }
}