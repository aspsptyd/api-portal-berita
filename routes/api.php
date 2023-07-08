<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/**
 * Access need auth
 **/
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthenticationController::class, 'logout']);

    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware('post-creator');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('post-creator');

    Route::post('/comment', [CommentController::class, 'store']);
});

/**
 * Get data posts
 **/
Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post2/{id}', [PostController::class, 'show2']);
Route::get('/post3/{id}', [PostController::class, 'show3']);

/**
 * Login for Authorization
 **/
Route::post('/login', [AuthenticationController::class, 'login']);