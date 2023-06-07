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

    public function detail(TodoList $todoList)
    {
        return response($todoList);
        // return response()->json($todoList);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        
        return TodoList::create($request->all());
        
        // return response()->json($todoList);
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete();

        // create import depedency for Response::HTTP_NO_CONTENT

        return response()->json("Deleted")->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    // create function update
    public function update(Request $request, TodoList $todoList)
    {
        $todoList->update($request->all());
        // create response json with statusCode for update method
        return response()->json($todoList)->setStatusCode(Response::HTTP_OK);
    }
}
