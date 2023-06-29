<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index()
    {
        // $datas = TodoList::all();
        // $datas = TodoList::where('user_id', auth()->user()->id)->get();
        $datas = auth()->user()->todoLists;
        return response()->json($datas);
        
        // * another way to calling authenticated user and using guard
        // $user = auth()->guard('sanctum')->user();
        // $user = Auth::guard('sanctum')->user();
    }

    public function show(TodoList $todo_list)
    {
        return response($todo_list);
        // return response()->json($todo_list);
    }

    public function store(TodoListRequest $request)
    {
        return auth()->user()->todoLists()->create($request->validated());
        
        /* $request['user_id'] = auth()->user()->id;
        return TodoList::create($request->validated()); */   
    }

    public function destroy(TodoList $todo_list)
    {
        $todo_list->delete();

        // create import depedency for Response::HTTP_NO_CONTENT

        return response()->json("Deleted")->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    // create function update
    public function update(TodoListRequest $request, TodoList $todo_list)
    {
        $todo_list->update($request->validated());
        return response()->json($todo_list)->setStatusCode(Response::HTTP_OK);
    }
}
