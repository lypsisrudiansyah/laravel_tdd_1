<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        // dd($tasks);
        return response()->json($tasks)->setStatusCode(200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $task = Task::create($data);
        return response()->json($task)->setStatusCode(201);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->all();
        $task->update($data);
        return response()->json($task)->setStatusCode(200);
    }

    public function show(Task $task)
    {
        return response()->json($task)->setStatusCode(200);
    }

}
