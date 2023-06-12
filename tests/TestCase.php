<?php

namespace Tests;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
    }

    /* public function tearDown(): void
    {
        parent::tearDown();
    } */

    public function createTask(array $args)
    {
        return Task::factory()->create($args ?? null);
    }

    public function createTodoList(array $args)
    {
        return TodoList::factory()->create($args ?? null);
    }
    
}
