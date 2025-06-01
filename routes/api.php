<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\RequireAuthorizationHeader;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

//    Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/posts', [PostController::class, 'index']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts/{post_id}', [PostController::class, 'show']);
        Route::match(['put', 'patch'], '/posts/{post_id}', [PostController::class, 'update']);
        Route::delete('/posts/{post_id}', [PostController::class, 'destroy']);
    });
});
