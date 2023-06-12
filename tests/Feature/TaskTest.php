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
        $response = $this->getJson('api/task')
            ->assertOk();

        $this->assertEquals(1, count($response->json()));
        $response->assertJsonStructure([
            '*' => ['id', 'title', 'description', 'status']
        ]);
    }

    public function testStoreTaskForATodoList()
    {
        $dataInput = Task::factory()->make()->toArray();
        $response = $this->postJson("api/task", $dataInput)
            ->assertCreated();

        $this->assertDatabaseHas('tasks', $dataInput);
    }

    public function testUpdateTaskForATodoList()
    {
        // hardcode dataInput
        $dataInput = ['title' => 'New Title', 'description' => 'New Description', 'status' => 'New Status'];
        $response = $this->putJson("api/task/{$this->task->id}", $dataInput)
            ->assertOk();

        $this->assertDatabaseHas('tasks', $dataInput);
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
            ->assertOk();
    }
}
