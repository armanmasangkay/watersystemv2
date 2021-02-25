<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    public function test_login_form_can_be_rendered()
    {
        $response=$this->get(route('login'));
        $response->assertViewIs('pages.login');
    }
}
