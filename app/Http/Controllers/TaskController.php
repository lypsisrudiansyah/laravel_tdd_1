<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(TodoList $todoList)
    {
        $tasks = $todoList->tasks;
        // $tasks = Task::where('todo_list_id', $todoList->id)->get();
        // dd($tasks);
        return response()->json($tasks)->setStatusCode(200);
    }

    public function store(TaskRequest $request, TodoList $todoList)
    {
        $request->validated();
        // dd($data);
        $task = $todoList->tasks()->create($request->validated());
        // $data['todo_list_id'] = $todoList->id;
        // return response()->json($task)->setStatusCode(201);
        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response()->json($task)->setStatusCode(200);
    }

    public function show(Task $task)
    {
        return response()->json($task)->setStatusCode(200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json($task)->setStatusCode(Response::HTTP_NO_CONTENT);
    }

}
