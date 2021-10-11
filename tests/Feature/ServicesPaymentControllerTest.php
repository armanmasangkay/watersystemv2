<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServicesPaymentControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     *  @test
     */
    public function servicesPaymentCanBeAccessByCashier()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);

        $response = $this->actingAs($user)->get(route('admin.services-payment'));

        $response->assertViewIs('pages.users.cashier.services-transaction-payment');
        $response->assertViewHasAll(['services', 'search_route']);
    }

    /**
     * @test
     */
    public function servicesPaymentCannotBeAccessByAdmin()
    {
        $user = User::factory()->create(['role' => User::$ADMIN]);

        $response = $this->actingAs($user)->get(route('admin.services-payment'));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentCannotBeAccessByBldgInspector()
    {
        $user = User::factory()->create(['role' => User::$BLDG_INSPECTOR]);

        $response = $this->actingAs($user)->get(route('admin.services-payment'));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentCannotBeAccessByWaterWorksInspector()
    {
        $user = User::factory()->create(['role' => User::$WATERWORKS_INSPECTOR]);

        $response = $this->actingAs($user)->get(route('admin.services-payment'));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentCannotBeAccessByMunicapalEngineer()
    {
        $user = User::factory()->create(['role' => User::$ENGINEER]);

        $response = $this->actingAs($user)->get(route('admin.services-payment'));

        $response->assertForbidden();
    }


    /**
     * @test
     */
    public function servicesPaymentSearchKeywordIsRequired()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services-payment-search'));
        $response->assertRedirect(route('admin.services-payment'));
        $response->assertSessionHasAll(['keyword' => '']);
    }

    /**
     * @test
     */
    public function servicesPaymentSearchReturnSessionErrorIfKeywordIsNotPresent()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);

        $response = $this->actingAs($user)->get(route('admin.services-payment-search'));
        $response->assertRedirect(route('admin.services-payment'));
        $response->assertSessionHasErrors(['keyword']);
    }

    /**
     * @test
     */
    public function servicesPaymentSearchCanBeAccessByCashier()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services-payment-search', ['keyword' => $customer->account_number]));
        $response->assertViewIs('pages.users.cashier.services-transaction-payment');
        $response->assertViewHasAll(['services', 'search_route']);
    }

    /**
     * @test
     */
    public function servicesPaymentSearchCannotBeAccessByAdmin()
    {
        $user = User::factory()->create(['role' => User::$ADMIN]);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services-payment-search', ['keyword' => $customer->account_number]));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSearchCannotBeAccessByBldgInspector()
    {
        $user = User::factory()->create(['role' => User::$BLDG_INSPECTOR]);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services-payment-search', ['keyword' => $customer->account_number]));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSearchCannotBeAccessByWaterWorksInspector()
    {
        $user = User::factory()->create(['role' => User::$WATERWORKS_INSPECTOR]);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services-payment-search', ['keyword' => $customer->account_number]));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSearchCannotBeAccessByMunicipalEngineer()
    {
        $user = User::factory()->create(['role' => User::$ENGINEER]);
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.services-payment-search', ['keyword' => $customer->account_number]));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSaveCanBeAccessByCashier()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[

        ]);
    }
}
