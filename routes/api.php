<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// sanctumの設定を行うとcorsエラーになる為 一旦middleware('auth:sanctum')->を省く
Route::get('/searchTaskList', [TaskController::class, "searchTaskList"])->name('api.taskList');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});