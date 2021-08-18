<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\StudentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//for admin
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::group(['prefix' => 'student', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [ApiController::class, 'logout']);
});

// for student
Route::post('/student/register', [StudentApiController::class, 'register']);
Route::post('/student/login', [StudentApiController::class, 'login']);
Route::group(['prefix' => 'student', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [StudentApiController::class, 'logout']);
    Route::get('show', [StudentApiController::class, 'getStudent']);
    Route::put('update', [StudentApiController::class, 'updateStudent']);
    Route::delete('delete', [StudentApiController::class, 'deleteStudent']);
});