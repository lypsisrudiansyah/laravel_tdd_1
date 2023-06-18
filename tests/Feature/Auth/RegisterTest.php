<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function testAUserCanRegister()
    {
        $response = $this->postJson('api/auth/register', [
            'name' => 'Rudiansyah',
            'email' => 'rudi@mail.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ])->assertCreated();

        $this->assertDatabaseHas('users', ['name' => 'Rudiansyah']);
    }
}
