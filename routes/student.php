<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Models\Chapter;
use Illuminate\Support\Facades\Route;


//GENERAL
Route::get('dashboard', ([StudentController::class, 'dashboard']))
    ->name('studentDashboard');

//COURSE
Route::get('courses', ([CourseController::class, 'studentIndex']))
    ->name('course_studentIndex');
Route::get('courses/{id}', ([CourseController::class, 'studentShow']))
    ->where('id', '[0-9]+')
    ->name('course_studentShow');

//CHAPTER
Route::get('chapter/{id}', ([ChapterController::class, 'studentShow']))
    ->where('id', '[0-9]+')
    ->name('chapter_studentShow');

//ASSIGNMENT
Route::get('assignment/{id}', ([AssignmentController::class, 'studentShow']))
    ->where('id', '[0-9]+')
    ->name('assignment_studentShow');