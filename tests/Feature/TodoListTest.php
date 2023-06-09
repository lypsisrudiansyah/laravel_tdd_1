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

        // & From Hardcoded
        // $data = ['name' => 'Todo List', 'user_id' => 1];
        // $this->list = $this->createTodoList($data);

        $user = $this->authUser();
        $this->list = $this->createTodoList(['user_id' => $user->id]);
    }

    public function testFetchIndexTodoList()
    {
        $this->createTodoList();
        $response = $this->getJson('api/todo-list')
            ->assertOk();
            
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'user_id']
        ]);
        $this->assertEquals(1, count($response->json()));
    }

    public function testFetchSingleTodoList()
    {
        $response = $this->getJson("api/todo-list/{$this->list->id}")
            ->assertOk()
            ->json();

        $this->assertEquals($response['name'], $this->list->name);
    }

    // create test fetchSingleTodoListNotFound
    public function testFetchSingleTodoListNotFound()
    {
        $this->withExceptionHandling();
        $response = $this->getJson("api/todo-list/999")
            ->assertNotFound();
    }

    public function testStoredTodoList()
    {
        // & From Hardcoded
        // $dataInput = ['name' => 'New Todo List', 'user_id' => 1];
        // & From Factory
        $dataInput = TodoList::factory()->make()->toArray();
        $response = $this->postJson("api/todo-list", $dataInput)
            ->assertCreated()->json();

        $this->assertEquals($dataInput['name'], $response['name']);
        $this->assertDatabaseHas('todo_lists', ['name' => $dataInput['name']]);
    }

    public function testWhileStoringTodoListNameAndUserIdIsRequired()
    {
        // ? why its not working while using $this->withoutExceptionHandling(); , answer: now i understand why thats not working, its about using not exception handling
        $this->withExceptionHandling();
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
        $this->withExceptionHandling();
        $dataInput = ['name' => '', 'user_id' => null];

        $this->patchJson("api/todo-list/{$this->list->id}", $dataInput)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    // create test testIfTodoListDeletedAllTaskRelatedWillBeDeleted
    public function testIfTodoListDeletedAllTaskRelatedWillBeDeleted()
    {
        // $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $this->list->id]);
        $task2 = $this->createTask([]);

        $this->deleteJson("api/todo-list/{$this->list->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['id' => $this->list->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
    }

}
