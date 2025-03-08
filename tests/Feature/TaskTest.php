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

        $this->authUser();
        $this->task = $this->createTask([]);
    }

    public function testFetchTasksOfATodoList()
    {
        $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);
        $response = $this->getJson("api/todo-list/{$todoList->id}/task")
            ->assertOk();
        // dd($response->getContent());

        $this->assertEquals(1, count($response->json()));
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'description', 'status']
            ]
        ]);
    }

    public function testStoreTaskOfATodoList()
    {
        // $dataInput = Task::factory()->make()->toArray();
        $todoList = $this->createTodoList([]);
        $label = $this->createLabel();
        $dataInput = $this->createTask(['todo_list_id' => $this->task->todo_list_id, 'label_id' => $label->id])->toArray();
        $dataInput['label_id'] = $label->id;
        $dataInputResp = $this->dataResponseResource($dataInput);
        // $dataInput = $this->task->toArray();
        // $response = $this->postJson("api/todo-list/{$this->task->todo_list_id}/task", $dataInput);
        $resp = $this->postJson("api/todo-list/{$this->task->todo_list_id}/task", $dataInput)
            ->assertCreated()->assertJsonStructure(array_keys($dataInputResp));
// dd($resp->json());
        $this->assertDatabaseHas('tasks', [
            'title' => $dataInput['title'],
            'status' => $dataInput['status'],
            'label_id' => $dataInput['label_id'],
        ]);
    }

    public function testStoreTaskOfATodoListWithoutLabel()
    {
        $todoList = $this->createTodoList([]);
        $label = $this->createLabel();
        $dataInput = $this->createTask(['todo_list_id' => $this->task->todo_list_id, 'label_id' => $label->id])->toArray();
        $dataInput['label_id'] = null;
        $dataInputResp = $this->dataResponseResource($dataInput);

        $this->postJson("api/todo-list/{$this->task->todo_list_id}/task", $dataInput)
            ->assertCreated()->assertJsonStructure(array_keys($dataInputResp));

        $this->assertDatabaseHas('tasks', [
            'title' => $dataInput['title'],
            'status' => $dataInput['status'],
            'label_id' => null,
        ]);
    }

    public function testStoreTaskOfATodoListWhileFieldRequiredFilledByEmptyValue()
    {
        $this->withExceptionHandling();
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

    // & Now Rules Update is allow Nullable Request because for some case it will be better way to check just filled data we updating on database
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

        $task = Task::factory()->create();
        $response = $this->getJson("api/task/{$task->id}")
            ->assertOk()
            ->json();

        $this->assertEquals($response['title'], $task->title);
    }

    public function testFetchSingleTaskNotFound()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();

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
