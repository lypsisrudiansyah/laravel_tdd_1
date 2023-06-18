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
        $response = $this->postJson('user/register');

        // $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'Rudiansyah']);
    }
}
