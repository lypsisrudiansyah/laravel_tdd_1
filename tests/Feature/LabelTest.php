<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

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
