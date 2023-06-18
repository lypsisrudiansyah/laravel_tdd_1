<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanLoginWithEmailAndPassword()
    {
        // $user = User::factory()->create([]);
        $user = $this->createUser();

        // dd($user);

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => '1234',
        ])->assertOk();

        $this->assertArrayHasKey('token', $response->json());
    }

    public function testIfUserEmailIsNotAvailableThenItReturnError()
    {
        $this->postJson('api/auth/login', [
            'email' => 'rudi@mail.com',
            'password' => '1234',
        ])->assertUnauthorized();
    }

    public function testIfUserPasswordThenItReturnError()
    {
        $user = $this->createUser();

        $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'random',
        ])->assertUnauthorized();
    }
}
