<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/auth/user', function (Request $request) {
    return response(Auth::user());
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::post('/project', [ProjectController::class, 'create']);
Route::get('/project/{project}', [ProjectController::class, 'get']);
Route::get('/project/updatedAt/{project}', [ProjectController::class, 'getUpdatedAt']);
Route::get('/projects', [ProjectController::class, 'infos']);