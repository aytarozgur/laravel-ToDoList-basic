<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Show task dashboard.
 */
Route::get('/', [TaskController::class, 'index']);
/**
 * Add new task.
 */
Route::post('/tasks', [TaskController::class, 'store']);

/**
 * Delete task.
 */
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
