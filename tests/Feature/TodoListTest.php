<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase ;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        /* $response = $this->get('/');

        $response->assertStatus(200); */
        TodoList::create(['name' => 'My Todo List', 'user_id' => 1]);
        
        $response = $this->getJson('api/todo-list');

        dd($response->getContent());
        $this->assertEquals(1, count($response->json()));
    }
}
