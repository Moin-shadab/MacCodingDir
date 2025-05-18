<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\PostController;
// Route::get('/', function () {
//     return 'Hi';
// });
Route::get('/', [PostController::class, 'index']);
Route::get('/posts/fetch', [PostController::class, 'fetch']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
