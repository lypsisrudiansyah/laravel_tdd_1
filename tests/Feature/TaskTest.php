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
        ->assertOk()
        ->json();

        // $this->assertEquals(1, count($response));
    }
}
