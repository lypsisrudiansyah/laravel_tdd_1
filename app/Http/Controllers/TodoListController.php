<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

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
        return TodoList::create($request->all());
        
        // return response()->json($todoList);
    }
}
