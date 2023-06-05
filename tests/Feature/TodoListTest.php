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


    public function testFetchIndexTodoList()
    {
        $response = $this->getJson('api/todo-list')
            ->assertOk();

        $this->assertEquals(1, count($response->json()));
    }

    public function testFetchDetailTodoList()
    {
        $todoList = TodoList::factory()->create();

        $response = $this->getJson("api/todo-list/{$todoList->id}")
            ->assertOk()
            ->json();

        $this->assertEquals($response['name'], $todoList->name);
    }

    public function testStoredTodoList()
    {
        // & From Hardcoded
        // $dataInput = ['name' => 'New Todo List', 'user_id' => 1];
        // & From Factory
        $dataInput = TodoList::factory()->make()->toArray();
        $response = $this->postJson("api/todo-list", $dataInput)
            ->assertCreated();

        // create assert databaseHas
        $this->assertDatabaseHas('todo_lists', $dataInput);
        $response->assertJson($dataInput);
    }

    public function testWhileStoringTodoListNameIsRequired()
    {
        $dataInput = ['name' => '', 'user_id' => 1];

        $this->postJson("api/todo-list", $dataInput)
        ->assertUnprocessable()
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
    
}
