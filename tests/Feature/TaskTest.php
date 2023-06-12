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

    // testStoreTask
    public function testStoreTaskForATodoList()
    {
        $dataInput = Task::factory()->make()->toArray();
        $response = $this->postJson("api/task", $dataInput)
            ->assertCreated();
    }
}
