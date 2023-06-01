<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        /* $response = $this->get('/');

        $response->assertStatus(200); */
        
        $this->withoutExceptionHandling();

        $response = $this->getJson('api/todo-list');
        // dd($response->json());
        $this->assertEquals(1, count($response->json()));
    }
}
