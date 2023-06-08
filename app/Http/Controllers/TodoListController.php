<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        $datas = TodoList::all();

        return response()->json($datas);
    }

    public function show(TodoList $todo_list)
    {
        return response($todo_list);
        // return response()->json($todo_list);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
        ]);
        
        return TodoList::create($request->all());
        
        // return response()->json($todo_list);
    }

    public function destroy(TodoList $todo_list)
    {
        $todo_list->delete();

        // create import depedency for Response::HTTP_NO_CONTENT

        return response()->json("Deleted")->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    // create function update
    public function update(Request $request, TodoList $todo_list)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
        ]);
        $todo_list->update($request->all());
        return response()->json($todo_list)->setStatusCode(Response::HTTP_OK);
    }
}
