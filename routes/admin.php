<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Models\Plan;
use Illuminate\Support\Facades\Route;

//GENERAL
Route::get('dashboard',[AdminController::class, 'dashboard'])->name('adminDashboard');	
Route::post('logout', [AdminAuthController::class, 'logout'])->name('adminLogout');

//SUBSCRIPTIONS
Route::get('plans', [PlanController::class, 'adminIndex'])
    ->name('plan_adminIndex');
Route::get('subscriptions/{id}', [PlanController::class, 'adminShow'])
    ->where('id', '[0-9]+')
    ->name('subscription_adminShow');

//USERS
Route::get('users', [UserController::class, 'adminIndex'])
    ->name('user_adminIndex');
Route::get('users/deleted', [UserController::class, 'adminDeletedAccounts'])
    ->name('user_adminDeletedAccounts');
Route::get('students', [StudentController::class, 'adminIndex'])
    ->name('student_adminIndex');
Route::get('teachers', [TeacherController::class, 'adminIndex'])
    ->name('teacher_adminIndex');
Route::get('teachers/{id}', [TeacherController::class, 'adminShow'])
    ->where('id', '[0-9]+')
    ->name('teacher_adminShow');


