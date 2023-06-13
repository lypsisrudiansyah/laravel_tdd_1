<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(array $attributes = [])
    {
        $todoListId = $attributes['todo_list_id'] ?? TodoList::factory()->create()->id;
        // dd($attributes);
        return [
            'todo_list_id' => $todoListId,
            'title' => fake()->name(),
            'description' => fake()->sentence(3),
            'status' => Task::STARTED,
        ];
    }
}
