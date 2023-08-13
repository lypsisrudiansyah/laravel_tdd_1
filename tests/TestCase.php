<?php

namespace Tests;

use App\Models\ExternalService;
use App\Models\Label;
use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /* public function tearDown(): void
    {
        parent::tearDown();
    } */

    public function createTask(array $args)
    {
        // return Task::factory()->create($args ?? null);
        return Task::factory()->state($args)->create();
    }

    public function createTodoList(array $args = [])
    {
        return TodoList::factory()->create($args ?? null);
    }

    public function createUser(array $args = [])
    {
        return User::factory()->create($args ?? null);
    }

    public function createLabel(array $args = [])
    {
        return Label::factory()->create($args ?? null);
    }

    public function createExternalService(array $args = [])
    {
        return ExternalService::factory()->create($args ?? null);
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }

    function dataResponseResource($dataInput) {
        return ['data' => $dataInput];
    }
    
}
