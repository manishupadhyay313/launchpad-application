<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;

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

Route::get('/', function () {
    session()->flush();
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminAuth']], function () {
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('student/edit/{userId}', [AdminDashboardController::class, 'editStudent'])->name('admin.edit-student');
    Route::get('teacher/edit/{userId}', [AdminDashboardController::class, 'editTeacher'])->name('admin.edit-teacher');
    route::patch('student/update/{userId}', [AdminDashboardController::class, 'updateStaudent'])->name('admin.update-student');
    route::patch('teacher/update/{userId}', [AdminDashboardController::class, 'updateTeacher'])->name('admin.update-teacher');
});

Route::group(['prefix' => 'teacher', 'middleware' => ['auth', 'teacherAuth']], function () {
    Route::get('dashboard', [TeacherDashboardController::class, 'dashboard'])->name('teacher.dashboard');
    Route::post('dashboard', [TeacherDashboardController::class, 'updateTeacherProfile'])->name('update.teacher.profile');
});

Route::group(['prefix' => 'student', 'middleware' => ['auth', 'studentAuth']], function () {
    Route::get('dashboard', [StudentDashboardController::class, 'dashboard'])->name('student.dashboard');
});
