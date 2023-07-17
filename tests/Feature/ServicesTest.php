<?php

namespace Tests\Feature;

use App\Models\ExternalService;
use Google\Client;
use App\CustomServices\GoogleOAuthApiClient;
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
        $this->mock(GoogleOAuthApiClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('setScopes'); 
            $mock->shouldReceive('createAuthUrl')->andReturn('http://localhost'); 
        });
        
        $response = $this->getJson('api/external-service/connect/google-drive')
        ->assertOk();

        $this->assertEquals('http://localhost', $response['auth_url']);
        $response->assertJsonStructure([
            'auth_url'
        ]);
        $this->assertNotNull($response['auth_url']);
    }

    public function testServiceCallbackWillStoreToken()
    {
        // $this->mock(GoogleOAuthApiClient::class, function (MockInterface $mock) {
        $this->mock(GoogleOAuthApiClient::class, function (MockInterface $mock) {
            // * Commented out because we are using the singleton instance of the Client class
            /* $mock->shouldReceive('setClientId')->once();   
            $mock->shouldReceive('setClientSecret')->once();   
            $mock->shouldReceive('setRedirectUri')->once();  */  
            
            $mock->shouldReceive('fetchAccessTokenWithAuthCode')
            ->andReturn(['access_token' => 'fake-token']);   
        });
        
        $res = $this->postJson('api/external-service/callback', [
            'code' => 'dummy-code',
        ])->assertCreated();

        // dd($res);
        
        $this->assertDatabaseHas('external_services', [
            'user_id' => $this->user->id,
            'name' => 'google-drive',
            'token' => '"{\"access_token\":\"fake-token\"}"',
            // 'token' => json_encode(['access_token' => 'fake-token']),
        ]);

        $this->assertNotNull($this->user->externalService->token);
    }

    public function testDataOfWeekCanBeStoreStored()
    {
        $this->createTask(['created_at' => now()->subDays(2)]);
        $this->createTask(['created_at' => now()->subDays(3)]);
        $this->createTask(['created_at' => now()->subDays(4)]);
        
        $this->mock(GoogleOAuthApiClient::class, function (MockInterface $mock) {
            // * Commented out because we are using the singleton instance of the Client class
            /* $mock->shouldReceive('setClientId')->once();   
            $mock->shouldReceive('setClientSecret')->once();   
            $mock->shouldReceive('setRedirectUri')->once();  */  
            
            $mock->shouldReceive('setAccessToken');
            $mock->shouldReceive('getLogger->info');
            $mock->shouldReceive('shouldDefer');
            $mock->shouldReceive('execute');
        });

        
        $externalService = $this->createExternalService();
        $this->postJson("api/external-service/store-data/$externalService->id")->assertCreated();
    }
}
 