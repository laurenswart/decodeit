<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubmissionController;
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
Route::get('chapters/{id}', ([ChapterController::class, 'studentShow']))
    ->where('id', '[0-9]+')
    ->name('chapter_studentShow');
Route::post('chapters/{id}', ([ChapterController::class, 'studentRead']))
    ->where('id', '[0-9]+')
    ->name('chapter_studentRead');

//ASSIGNMENT
Route::get('assignments/{id}', ([AssignmentController::class, 'studentShow']))
    ->where('id', '[0-9]+')
    ->name('assignment_studentShow');

//SUBMISSION
Route::post('assignments/{id}', ([SubmissionController::class, 'studentStore']))
    ->where('id', '[0-9]+')
    ->name('submission_studentStore');