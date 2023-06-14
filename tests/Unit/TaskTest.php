<?php

namespace Tests\Unit;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskBelongsToTodoList()
    {
        $todoList = $this->createTodoList([]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);

        $this->assertInstanceOf(TodoList::class, $task->todoList);
        $this->assertEquals($todoList->id, $task->todoList->id);
    }
}
