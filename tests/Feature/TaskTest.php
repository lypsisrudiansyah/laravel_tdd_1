<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    private $task;


    public function setUp(): void
    {
        parent::setUp();

        $this->task = $this->createTask([]);
    }

    public function testFetchTasksOfATodoList()
    {
        $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);
        $response = $this->getJson("api/todo-list/{$todoList->id}/task")
            ->assertOk();

        $this->assertEquals(1, count($response->json()));
        $response->assertJsonStructure([
            '*' => ['id', 'title', 'description', 'status']
        ]);
    }

    public function testStoreTaskOfATodoList()
    {
        // $dataInput = Task::factory()->make()->toArray();
        $todoList = $this->createTodoList([]);
        $dataInput = $this->createTask(['todo_list_id' => $todoList->id, 'id' => null])->toArray();
        // dd($dataInput);
        $response = $this->postJson("api/todo-list/{$todoList->id}/task", $dataInput)
            ->assertCreated();

        // $this->assertDatabaseHas('tasks', $dataInput);
        $this->assertDatabaseCount('tasks', 1);
    }

    public function testStoreTaskOfATodoListWhileFieldRequiredFilledByEmptyValue()
    {
        $dataInput = Task::factory()->make(['title' => '', 'description' => 'New Description', 'status' => ''])->toArray();
        $response = $this->postJson("api/todo-list/{$this->task->todo_list_id}/task", $dataInput)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'status']);
    }

    public function testUpdateTaskOfATodoList()
    {
        // hardcode dataInput
        $dataInput = ['title' => 'New Title', 'description' => 'New Description', 'status' => 'New Status'];
        $response = $this->putJson("api/task/{$this->task->id}", $dataInput)
            ->assertOk();

        $this->assertDatabaseHas('tasks', $dataInput);
    }

    public function testUpdateTaskOfATodoListWhileFieldRequiredFilledByEmptyValue()
    {
        $dataInput = ['title' => '', 'description' => 'New Description', 'status' => ''];
        $response = $this->putJson("api/task/{$this->task->id}", $dataInput)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'status']);
    }

    public function testFetchSingleTask()
    {
        $task = Task::factory()->create();
        $response = $this->getJson("api/task/{$task->id}")
            ->assertOk()
            ->json();

        $this->assertEquals($response['title'], $task->title);
    }

    public function testFetchSingleTaskNotFound()
    {
        $response = $this->getJson("api/task/999")
            ->assertNotFound();
    }

    // testDeleteTask
    public function testDeleteTask()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("api/task/{$task->id}")
            ->assertNoContent();
    }
}
