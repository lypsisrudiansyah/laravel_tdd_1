<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExternalService>
 */
class ExternalServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'google-drive',
            'token' => ['access_token' => 'fake-token'],
            'user_id' => function() {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
