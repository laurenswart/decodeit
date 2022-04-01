<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;


//GENERAL
Route::get('dashboard', ([TeacherController::class, 'dashboard']))
    ->name('teacherDashboard');

//COURSE
Route::get('courses', ([CourseController::class, 'teacherIndex']))
    ->name('course_teacherIndex');
Route::get('courses/{id}', ([CourseController::class, 'teacherShow']))
    ->where('id', '[0-9]+')
    ->name('course_teacherShow');
    
//CHAPTER
Route::get('chapter/{id}', ([ChapterController::class, 'chapter_teacherShow']))
    ->where('id', '[0-9]+')
    ->name('chapter_teacherShow');

//ASSIGNMENT
Route::get('assignment/{id}', ([AssignmentController::class, 'assignment_teacherShow']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherShow');

//STUDENT
Route::get('students', ([StudentController::class, 'teacherIndex']))
    ->name('student_teacherIndex');