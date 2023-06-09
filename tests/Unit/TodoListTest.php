<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function testTodoListCanHasManyTasks()
    {
        // $user = $this->authUser();
        $user = $this->createUser();
        $todoList = $this->createTodoList(['user_id' => $user->id]);
        $task = $this->createTask(['todo_list_id' => $todoList->id]);

    
        $this->assertTrue($todoList->tasks->contains($task));
        $this->assertInstanceOf(Task::class, $todoList->tasks->first());
        $this->assertInstanceOf(Collection::class, $todoList->tasks);
        // $todoList = TodoList::factory()->create();
        // $task = Task::factory()->create(['todo_list_id' => $todoList->id]);
        // $this->assertEquals(1, $todoList->tasks->count());
    }

}
