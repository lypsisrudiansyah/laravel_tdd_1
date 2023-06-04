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
    public function test_fetch_index_todo_list()
    {
        // TodoList::create(['name' => 'My Todo List', 'user_id' => 1]);
        TodoList::factory()->create();

        $response = $this->getJson('api/todo-list');
        dd($response->getContent());

        $this->assertEquals(1, count($response->json()));
    }

    public function test_fetch_detail_todo_list()
    {
        $todoList = TodoList::factory()->create();
        
        $response = $this->getJson("api/todo-list/{$todoList->id}");
        dd($response->getContent());

        $response->assertStatus(200);
        // $this->assertEquals(1, count($response->json()));
    }
}
