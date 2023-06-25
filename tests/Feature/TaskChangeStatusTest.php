<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskChangeStatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function testChangeStatusTaskToStarted()
    {
        $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);
        $dataInput = ['status' => Task::STARTED];

        $response = $this->putJson("api/task/{$task->id}", $dataInput)
            ->assertOk()
            ->assertJsonStructure(array_keys($dataInput));
        $this->assertEquals(Task::STARTED, $response->json()['status']);
        $this->assertDatabaseHas('tasks',['status' => Task::STARTED]);
    }

    public function testChangeStatusTaskToPending()
    {
        $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);
        $dataInput = ['status' => Task::PENDING];

        $response = $this->putJson("api/task/{$task->id}", $dataInput)
            ->assertOk()
            ->assertJsonStructure(array_keys($dataInput));
        $this->assertEquals(Task::PENDING, $response->json()['status']);
        $this->assertDatabaseHas('tasks',['status' => Task::PENDING]);
    }

    public function testChangeStatusTaskToDone()
    {
        $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);
        $dataInput = ['status' => Task::DONE];

        $response = $this->putJson("api/task/{$task->id}", $dataInput)
            ->assertOk()
            ->assertJsonStructure(array_keys($dataInput));
        $this->assertEquals(Task::DONE, $response->json()['status']);
        $this->assertDatabaseHas('tasks',['status' => Task::DONE]);
    }
}
