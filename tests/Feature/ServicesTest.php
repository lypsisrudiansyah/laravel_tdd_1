<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use RefreshDatabase;
    
    public function testAUserCanConnectToGoogleServiceAndTokenStored()
    {
        $this->authUser();
        
        $this->getJson('api/service/connect/google-drive')
        ->assertOk()->json();

    }
}
