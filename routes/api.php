<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser'])->name('loginUser');
// Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{id}/avatar', [UserController::class, 'showUploadForm'])->name('upload.avatar.form');
Route::post('/users/{id}/avatar', [UserController::class, 'uploadAvatar'])->name('upload.avatar');
Route::get('/users/{id}/posts/{post_id}', [PostController::class, 'show']);

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/users/{id}/posts', [PostController::class, 'index'])->name('user.posts');;
Route::post('/users/{id}/posts', [PostController::class, 'store']);
Route::put('/users/{id}/posts/{post_id}', [PostController::class, 'update']);
Route::delete('/users/{id}/posts/{post_id}', [PostController::class, 'destroy']);

Route::get('/users/{id}/roles', [RoleController::class, 'index']);

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/users/{id}/roles', [RoleController::class, 'index'])->name('role');

Route::get('/users/xd', [UsersController::class, 'allusers'])->name('users');


