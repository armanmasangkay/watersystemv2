<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\PaymentWorkOrder;
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
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => true]);
        $this->assertDatabaseCount('payment_work_orders', 1);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveCannotBeAccessByAdmin()
    {
        $user = User::factory()->create(['role' => User::$ADMIN]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSaveCannotBeAccessByBldgInspector()
    {
        $user = User::factory()->create(['role' => User::$BLDG_INSPECTOR]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSaveCannotBeAccessByWaterWorksInspector()
    {
        $user = User::factory()->create(['role' => User::$WATERWORKS_INSPECTOR]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSaveCannotBeAccessByEngineer()
    {
        $user = User::factory()->create(['role' => User::$ENGINEER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function servicesPaymentSaveOrNumberShouldBePresent()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['orNum' => ["OR number should not be empty."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveOrNumberShouldBeUnique()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);
        $pwo = PaymentWorkOrder::create([
            'customer_id' => $customer->account_number,
            'service_id' => $service->id,
            'or_no' => '12345',
            'payment_amount' => '100',
            'remarks' => "Anything",
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => $pwo->or_no,
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);
        $response->assertExactJson(['created' => false, 'errors' => ['orNum' => ["OR number cannot be the same with the existing issued OR number."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveInputedAmountShouldBeRequired()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['inputedAmount' => ["Inputed amount should not be empty."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveInputedAmountShouldBeNumber()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => 'Random String',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['inputedAmount' => ["Inputed amount should be a number format.","Inputed amount should be greater than zero.","Inputed amount should be greater than or equal to Amount."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveInputedAmountShouldBeGreaterThanZero()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '-1',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['inputedAmount' => ["Inputed amount should be greater than zero.","Inputed amount should be greater than or equal to Amount."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveInputedAmountShouldBeGreaterThanOrEqualToAmount()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '10',
            'customer_id' => $customer->account_number,
            'amount' => '100',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['inputedAmount' => ["Inputed amount should be greater than or equal to Amount."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveAmountShouldBeRequired()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['amount' => ["Amount should not be empty."],"inputedAmount" => ["Inputed amount should be greater than or equal to Amount."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveAmountShouldBeGreaterThanZero()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => '-1',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['amount' => ["Amount should be greater than zero."]] ]);
    }

    /**
     * @test
     */
    public function servicesPaymentSaveAmountShouldBeNumber()
    {
        $user = User::factory()->create(['role' => User::$CASHIER]);
        $customer = Customer::factory()->create();
        $service = Service::create([
            'customer_id' => $customer->account_number,
            'type_of_service' => 'new_connection',
            'status' => Service::$PENDING_FOR_PAYMENT,
            'request_number' => Service::generateUniqueIdentifier(),
            'start_status' => Service::$PENDING_BUILDING_INSPECTION
        ]);

        $response = $this->actingAs($user)->post(route('admin.services-payment-save'),[
            'orNum' => '12345',
            'inputedAmount' => '200',
            'customer_id' => $customer->account_number,
            'amount' => 'Random String',
            'remarks' => "Anything",
            'id' => $service->id,
        ]);

        $response->assertExactJson(['created' => false, 'errors' => ['amount' => ["Amount should be a number format.","Amount should be greater than zero."]] ]);
    }
}
