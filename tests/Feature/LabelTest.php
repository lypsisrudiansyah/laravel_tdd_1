<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }
    
    public function testUserCanCreateNewLabel()
    {

        $dataInput = [
            'title' => 'Test Label',
            'color' => 'red',
        ];

        $response = $this->postJson('/api/label', $dataInput)->assertCreated();

        $this->assertDatabaseHas('labels', $dataInput);
    }
}
