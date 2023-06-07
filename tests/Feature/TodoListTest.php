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

    public function testWhileStoringTodoListNameAndUserIdIsRequired()
    {
        // ? why its not working while using $this->withoutExceptionHandling();
        $dataInput = ['name' => '', 'user_id' => null];

        $this->postJson("api/todo-list", $dataInput)
        ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'user_id']);
    }

    public function testDeleteTodoList()
    {
        $this->deleteJson("api/todo-list/{$this->list->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['id' => $this->list->id]);
    }

    public function testUpdateTodoList()
    {
        $dataInput = ['name' => 'Updated Todo List', 'user_id' => 1];

        $this->patchJson("api/todo-list/{$this->list->id}", $dataInput)
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', $dataInput);
    }

    public function testWhileUpdateTodoListNameIsRequired()
    {
        $dataInput = ['name' => '', 'user_id' => null];

        $this->patchJson("api/todo-list/{$this->list->id}", $dataInput)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);

    }
    
}
