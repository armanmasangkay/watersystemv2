<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountOfficerTest extends TestCase
{
    use RefreshDatabase;
    private function getOfficer()
    {
        return User::factory()->create([
            'role' => 7
        ]);
    }

    private function login($accountOfficer)
    {
        return $this->post('/login', [
            'username' => $accountOfficer->username,
            'password' => '1234'
        ]);
    }

    private function createAndLoginOfficer()
    {
        $accountOfficer = $this->getOfficer();

        return $this->login($accountOfficer);
    }
    public function test_login()
    {
        $response = $this->createAndLoginOfficer();

        $response->assertRedirect(route('account-officer.dashboard'));
    }

    public function test_dashboard_view()
    {
        $this->createAndLoginOfficer();

        $response = $this->get(route('account-officer.dashboard'));
        $response->assertViewIs('account-officer.dashboard');
        $response->assertViewHas('accounts');

    }

    public function test_dashboard_view_when_no_account()
    {
        $this->createAndLoginOfficer();

        $response = $this->get(route('account-officer.dashboard'));
        $response->assertSeeText('No accounts to show!');
        $response->assertDontSeeText('Email');
        $response->assertDontSeeText('Mobile Number');

    }
    public function test_dashboard_protection()
    {
        $response = $this->get(route('account-officer.dashboard'));
        $response->assertRedirect('/login');
    }

    public function test_reset_password()
    {
        $this->createAndLoginOfficer();

        $consumer = Account::factory()->create([
            'password' => '123456'
        ]);
        $response = $this->put('/account-officer/reset-password/consumer/' . $consumer->id);
        $updatedConsumer = Account::find($consumer->id);
        $this->assertTrue(Hash::check('1234', $updatedConsumer->password));
        $response->assertRedirect('/account-officer/dashboard/');
        $response->assertSessionHas('message', $updatedConsumer->account_number . ' password is updated successfully!');
    }
}
