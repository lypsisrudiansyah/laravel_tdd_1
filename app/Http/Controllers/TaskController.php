<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        // dd($tasks);
        return response()->json($tasks)->setStatusCode(200);
    }

    public function store(TaskRequest $request)
    {
        $data = $request->all();
        $task = Task::create($data);
        return response()->json($task)->setStatusCode(201);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->all();
        $task->update($data);
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
