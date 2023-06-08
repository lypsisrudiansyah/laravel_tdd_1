<?php

use App\Http\Controllers\TodoListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// * Manually define routing bundling on apiResource
Route::apiResource('todo-list', TodoListController::class);

// * Manually define each routing
/* Route::get('todo-list', [TodoListController::class, 'index']);
Route::post('todo-list', [TodoListController::class, 'store']);
Route::patch('todo-list/{todoList}', [TodoListController::class, 'update']);
Route::get('todo-list/{todoList}', [TodoListController::class, 'show']);
Route::delete('todo-list/{todoList}', [TodoListController::class, 'destroy']);
 */