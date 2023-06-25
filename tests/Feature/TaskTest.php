<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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
        $dataInput = $this->createTask(['todo_list_id' => $this->task->todo_list_id, 'id' => null])->toArray();
        // $dataInput = $this->task->toArray();
        // dd($dataInput);
        $response = $this->postJson("api/todo-list/{$this->task->todo_list_id}/task", $dataInput)
            ->assertCreated()->assertJsonStructure(array_keys($dataInput));
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
        // $this->withoutExceptionHandling();
        // hardcode dataInput
        $dataInput = ['title' => 'New Title', 'description' => 'New Description', 'status' => 'New Status'];
        $response = $this->putJson("api/task/{$this->task->id}", $dataInput)
            ->assertOk();

        $this->assertDatabaseHas('tasks', $dataInput);
    }

    // & Now Rules Update is allow Nullable Request
    /* public function testUpdateTaskOfATodoListWhileFieldRequiredFilledByEmptyValue()
    {
        $dataInput = ['title' => '', 'description' => 'New Description', 'status' => ''];
        $response = $this->putJson("api/task/{$this->task->id}", $dataInput)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'status']);
    } */

    public function testFetchSingleTask()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);
        
        $task = Task::factory()->create();
        $response = $this->getJson("api/task/{$task->id}")
            ->assertOk()
            ->json();

        $this->assertEquals($response['title'], $task->title);
    }

    public function testFetchSingleTaskNotFound()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

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
