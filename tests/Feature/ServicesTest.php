<?php

namespace Tests\Feature;

use App\Models\ExternalService;
use Google\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
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
        $response = $this->getJson('api/external-service/connect/google-drive')
        ->assertOk();

        $response->assertJsonStructure([
            'auth_url'
        ]);
        $this->assertNotNull($response['auth_url']);
    }

    public function testServiceCallbackWillStoreToken()
    {
        $this->mock(Client::class, function (MockInterface $mock) {
            $mock->shouldReceive('setClientId')->once();   
            $mock->shouldReceive('setClientSecret')->once();   
            $mock->shouldReceive('setRedirectUri')->once();   
            $mock->shouldReceive('setScopes')->once();   
            $mock->shouldReceive('fetchAccessTokenWithAuthCode')
            ->andReturn(['access_token' => 'fake-token']);   
        });
        
        $this->postJson('api/external-service/callback', [
            'code' => 'dummy-code',
        ])->assertCreated();

        $this->assertDatabaseHas('external_services', [
            'user_id' => $this->user->id,
            'name' => 'google-drive',
        ]);

        $this->assertNotNull($this->user->externalService->token);
    }
}
 