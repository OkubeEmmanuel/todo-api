<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use App\Models\Todo;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('todo')->group( function () {
        Route::get('', [TodoController::class, 'index']);
        Route::get('{todo}', [TodoController::class, 'show']);
        Route::post('new', [TodoController::class, 'store']);
        Route::put('update/{todo}', [TodoController::class, 'update']);
        Route::delete('delete/{todo}', [TodoController::class, 'destroy']);
        Route::patch('completed/{todo}', [TodoController::class, 'taskCompleted']);
        Route::patch('notcompleted/{todo}', [TodoController::class, 'taskNotCompleted']);
    });
});

