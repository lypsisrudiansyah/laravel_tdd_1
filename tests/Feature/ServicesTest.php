<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAUserCanConnectToGoogleServiceAndTokenStored()
    {
        $this->getJson('google-service/connect')
        ->assertOk->json();
        
    }
}
