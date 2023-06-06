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
        // create return response json with status code 204

        
    }
}
