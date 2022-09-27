<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

// Add routes for user endpoints
Route::middleware(['auth:api'])->controller(UserController::class)->group(function () {
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'store');
});

// Add routes for thread endpoints
Route::middleware(['auth:api'])->controller(ThreadController::class)->group(function () {
    Route::get('/threads/{user_id}', 'index');
    Route::post('/threads', 'store');
    Route::patch('/threads/{id}', 'update');
});

// Add routes for message endpoints
Route::middleware(['auth:api'])->controller(MessageController::class)->group(function () {
    Route::get('/messages/{thread_id}', 'index');
    Route::post('/messages', 'store');
});

// Add routes for tag endpoints
Route::middleware(['auth:api'])->controller(TagController::class)->group(function () {
    Route::get('/tags', 'index');
    Route::post('/tags', 'store');
});
