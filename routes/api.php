<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post2/{id}', [PostController::class, 'show2']);