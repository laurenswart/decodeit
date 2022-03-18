<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Models\Chapter;
use Illuminate\Support\Facades\Route;



Route::get('dashboard', ([StudentController::class, 'dashboard']))
    ->name('studentDashboard');

Route::get('courses', ([CourseController::class, 'studentCourses']))
    ->name('studentCourses');

Route::get('courses/{id}', ([CourseController::class, 'studentCourse']))
    ->where('id', '[0-9]+')->name('studentCourse');
    
Route::get('chapter/{id}', ([ChapterController::class, 'studentChapter']))
    ->where('id', '[0-9]+')->name('studentChapter');

Route::get('assignment/{id}', ([AssignmentController::class, 'studentAssignment']))
    ->where('id', '[0-9]+')->name('studentAssignment');