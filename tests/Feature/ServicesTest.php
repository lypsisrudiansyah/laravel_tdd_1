<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }
    
    public function testAUserCanConnectToGoogleServiceAndTokenStored()
    {
        $response = $this->getJson('api/service/connect/google-drive')
        ->assertOk();

        $response->assertJsonStructure([
            'auth_url'
        ]);
        $this->assertNotNull($response['auth_url']);
    }

    public function testServiceCallbackWillStoreToken()
    {
        $this->postJson('service/callback')->assertOk();
    }
}
 