<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ExternalServiceController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todo-list', TodoListController::class);
    
    Route::get('task/{task}', [TaskController::class, 'show'])->name('task.show');
    Route::apiResource('todo-list.task', TaskController::class)->except('show')->shallow();

    Route::apiResource('label', LabelController::class);

    Route::get('external-service/connect/{serviceName}', [ExternalServiceController::class, 'connectService']);
    Route::post('external-service/callback', [ExternalServiceController::class, 'callback']);
    Route::post('external-service/store-data/{service}', [ExternalServiceController::class, 'storeData']);
});


Route::post('auth/register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('auth/login', [LoginController::class, 'login'])->name('auth.login');


// Route::apiResource('todo-list/{todo_list}/task', TaskController::class)->except('show')->shallow();
// Route::apiResource('/task', TaskController::class);
// Route::get('task', [TaskController::class, 'index']);

// * Manually define each routing
/* Route::get('todo-list', [TodoListController::class, 'index']);
Route::post('todo-list', [TodoListController::class, 'store']);
Route::patch('todo-list/{todoList}', [TodoListController::class, 'update']);
Route::get('todo-list/{todoList}', [TodoListController::class, 'show']);
Route::delete('todo-list/{todoList}', [TodoListController::class, 'destroy']);
 */