<?php

use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\StudentApiController;
use App\Http\Controllers\TeacherApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//for admin
Route::post('/admin/login', [AdminApiController::class, 'login']);
Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [AdminApiController::class, 'logout']);
    Route::get('profile', [AdminApiController::class, 'profile']);
});

// for student
Route::post('/student/register', [StudentApiController::class, 'register']);
Route::post('/student/login', [StudentApiController::class, 'login']);
Route::group(['prefix' => 'student', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [StudentApiController::class, 'logout']);
    Route::get('profile', [StudentApiController::class, 'profile']);
    Route::patch('update/{userId}', [StudentApiController::class, 'updateStudent']);
    Route::delete('delete/{userId}', [StudentApiController::class, 'deleteStudent']);
});

// for Teacher
Route::post('/teacher/register', [TeacherApiController::class, 'register']);
Route::post('/teacher/login', [TeacherApiController::class, 'login']);
Route::group(['prefix' => 'teacher', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [TeacherApiController::class, 'logout']);
    Route::get('profile', [TeacherApiController::class, 'profile']);
    Route::patch('update/{userId}', [TeacherApiController::class, 'update']);
    Route::delete('delete/{userId}', [TeacherApiController::class, 'delete']);
});