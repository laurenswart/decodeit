<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;



Route::get('dashboard', ([StudentController::class, 'dashboard']))
    ->name('studentDashboard');
