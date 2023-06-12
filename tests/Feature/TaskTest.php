<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFetchTasksOfATodoList()
    {
        Task::factory()->create();

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
    }

    public function testUpdateTaskForATodoList()
    {
        $task = Task::factory()->create();
        $dataInput = Task::factory()->make()->toArray();
        $response = $this->putJson("api/task/{$task->id}", $dataInput)
            ->assertOk();
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

}
