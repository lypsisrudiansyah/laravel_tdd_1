<?php

namespace Database\Factories;

use App\Models\Label;
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
        $labelId = $attributes['label_id'] ?? Label::factory()->create()->id;
        return [
            'todo_list_id' => $todoListId,
            'label_id' => $labelId,
            'title' => fake()->name(),
            'description' => fake()->sentence(3),
            'status' => Task::STARTED,
        ];
    }
}
