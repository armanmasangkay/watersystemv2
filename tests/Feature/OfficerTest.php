<?php

namespace Tests\Feature;

use App\Models\Officer;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficerTest extends TestCase
{
    use RefreshDatabase;
    public function test_only_admin_can_access_officers()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.officers.index'));

        $response->assertViewIs('pages.officers.index');
    }

    public function test_fail_if_cashier_user_try_to_access_officers()
    {
        $user = User::factory()->create([
            'role' => User::$CASHIER
        ]);

        $response = $this->actingAs($user)->get(route('admin.officers.index'));

        $response->assertForbidden();
    }

    public function test_fail_if_waterworks_user_try_to_access_officers()
    {
        $user = User::factory()->create([
            'role' => User::$WATERWORKS_INSPECTOR
        ]);

        $response = $this->actingAs($user)->get(route('admin.officers.index'));

        $response->assertForbidden();
    }

    public function test_fail_if_bldg_inspector_user_try_to_access_officers()
    {
        $user = User::factory()->create([
            'role' => User::$BLDG_INSPECTOR
        ]);

        $response = $this->actingAs($user)->get(route('admin.officers.index'));

        $response->assertForbidden();
    }

    public function test_fail_if_municipal_engineer_user_try_to_access_officers()
    {
        $user = User::factory()->create([
            'role' => User::$ENGINEER
        ]);

        $response = $this->actingAs($user)->get(route('admin.officers.index'));

        $response->assertForbidden();
    }

    public function test_display_all_officer()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.officers.index'));

        $response->assertViewHas('officers');
    }

    public function test_admin_can_access_add_officers_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.officers.create'));
        $response->assertViewIs('pages.officers.create');
    }

    public function test_fail_if_fullname_is_empty()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.officers.store'),
        [
            'fullname' => '',
            'position' => Officer::$INTERNAL_AUDITOR_I
        ]);
        $this->assertDatabaseCount('officers', 0);
        $response->assertSessionHasAll(['created' => false]);
        $response->assertSessionHasErrors(['fullname']);
    }

    public function test_fail_if_position_is_empty()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.officers.store'),
        [
            'fullname' => 'June Vic Cadayona',
            'position' => ''
        ]);
        $this->assertDatabaseCount('officers', 0);
        $response->assertSessionHasAll(['created' => false]);
        $response->assertSessionHasErrors(['position']);
    }

    public function test_fail_if_position_is_invalid()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.officers.store'),
        [
            'fullname' => 'June Vic Cadayona',
            'position' => 'internal_audit_2'
        ]);

        $response->assertSessionHasAll(['created' => false]);
        $this->assertDatabaseCount('officers', 0);
        $response->assertSessionHasErrors(['position']);
    }

    public function test_save_officer_if_required_fields_are_filled()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('admin.officers.store'),
        [
            'fullname' => 'John Doe',
            'position' => Officer::$INTERNAL_AUDITOR_I
        ]);

        $response->assertRedirect(route('admin.officers.index'));
        $response->assertSessionHasAll(['created' => true]);
        $this->assertDatabaseCount('officers', 1);
        $this->assertDatabaseHas('officers',['fullname' => 'John Doe']);
    }

    public function test_fail_if_officer_not_found()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.officers.edit',1));
        $response->assertNotFound();
    }

    public function test_display_details_if_the_officer_is_exist()
    {
        $user = User::factory()->create();
        $officer = Officer::factory()->create(['position' => Officer::$INTERNAL_AUDITOR_I]);
        $response = $this->actingAs($user)->get(route('admin.officers.edit', $officer));
        $response->assertViewIs('pages.officers.edit');
        $response->assertViewHas('officer');
    }

    public function test_update_fail_if_fullname_is_empty()
    {
        $user = User::factory()->create();
        $officer = Officer::factory()->create(['position' => Officer::$INTERNAL_AUDITOR_I]);
        $response = $this->actingAs($user)->put(route('admin.officers.update', $officer),
        [
            'fullname' => '',
            'position' => Officer::$INTERNAL_AUDITOR_I
        ]);
        $response->assertSessionHasAll(['created' => false]);
        $response->assertSessionHasErrors(['fullname']);
    }

    public function test_update_fail_if_position_is_empty()
    {
        $user = User::factory()->create();
        $officer = Officer::factory()->create(['position' => Officer::$INTERNAL_AUDITOR_I]);
        $response = $this->actingAs($user)->put(route('admin.officers.update', $officer),
        [
            'fullname' => 'June Vic Cadayona',
            'position' => ''
        ]);
        $response->assertSessionHasAll(['created' => false]);
        $response->assertSessionHasErrors(['position']);
    }

    public function test_update_fail_if_position_is_invalid()
    {
        $user = User::factory()->create();
        $officer = Officer::factory()->create(['position' => Officer::$INTERNAL_AUDITOR_I]);
        $response = $this->actingAs($user)->put(route('admin.officers.update', $officer),
        [
            'fullname' => 'June Vic Cadayona',
            'position' => 'internal_audit_2'
        ]);

        $response->assertSessionHasAll(['created' => false]);
        $response->assertSessionHasErrors(['position']);
    }

    public function test_update_officer_if_required_fields_are_filled()
    {
        $user = User::factory()->create();
        $officer = Officer::factory()->create(['position' => Officer::$INTERNAL_AUDITOR_I]);
        $response = $this->actingAs($user)->put(route('admin.officers.update', $officer),
        [
            'fullname' => 'John Doe',
            'position' => Officer::$INTERNAL_AUDITOR_I
        ]);

        $response->assertRedirect(route('admin.officers.index'));
        $response->assertSessionHasAll(['created' => true]);
        $this->assertDatabaseHas('officers',['fullname' => 'John Doe']);
    }

    public function test_delete_officer()
    {
        $user = User::factory()->create();
        $officer = Officer::factory()->create(['position'=> Officer::$INTERNAL_AUDITOR_I]);
        $response = $this->actingAs($user)->delete(route('admin.officers.destroy', $officer));
        $response->assertRedirect(route('admin.officers.index'));
        $response->assertSessionHasAll(['created' => true]);
        $this->assertDatabaseCount('officers', 0);
    }
}
