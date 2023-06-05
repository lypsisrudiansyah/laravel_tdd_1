<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp(): void
    {
        parent::setUp();

        $this->list = TodoList::factory()->create();
    }


    public function test_fetch_index_todo_list()
    {
        $response = $this->getJson('api/todo-list')
                    ->assertOk();

        $this->assertEquals(1, count($response->json()));
    }

    public function test_fetch_detail_todo_list()
    {
        $todoList = TodoList::factory()->create();

        $response = $this->getJson("api/todo-list/{$todoList->id}")
            ->assertOk()
            ->json();

        $this->assertEquals($response['name'], $todoList->name);
    }

    public function test_create__todo_list()
    {
        $dataInput = ['name' => 'New Todo List', 'user_id' => 1];
        $response = $this->postJson("api/todo-list", $dataInput)
            ->assertCreated()
            ->json();
        
            // create assert databaseHas
            $this->assertDatabaseHas('todo_lists', ['name' => 'New Todo List', 'user_id' => 1]);
        $this->assertDatabase
    }
}
