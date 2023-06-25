<?php

namespace Tests\Unit;

use App\Models\TodoList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    // func testUserHasManyTodoLists
    public function testUserHasManyTodoLists()
    {
        $user = $this->createUser();
        $todoList = $this->createTodoList(['user_id' => $user->id]);

        $this->assertTrue($user->todoLists->contains($todoList));
        $this->assertInstanceOf(TodoList::class, $user->todoLists->first());
        $this->assertInstanceOf(Collection::class, $user->todoLists);
    }
}
