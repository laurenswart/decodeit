<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeacherController;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//GENERAL
Route::get('dashboard', ([TeacherController::class, 'dashboard']))
    ->name('teacherDashboard');
Route::get('account', ([TeacherController::class, 'account']))
    ->name('teacher_account');

//COURSE
Route::get('courses', ([CourseController::class, 'teacherIndex']))
    ->name('course_teacherIndex');
Route::get('courses/{id}', ([CourseController::class, 'teacherShow']))
    ->where('id', '[0-9]+')
    ->name('course_teacherShow');
Route::get('courses/new', ([CourseController::class, 'teacherCreate']))
    ->name('course_teacherCreate');
Route::post('courses', ([CourseController::class, 'teacherStore']))
    ->name('course_teacherStore');
Route::get('courses/{id}/edit', ([CourseController::class, 'teacherEdit']))
    ->where('id', '[0-9]+')
    ->name('course_teacherEdit');
Route::post('courses/{id}', ([CourseController::class, 'teacherUpdate']))
    ->where('id', '[0-9]+')
    ->name('course_teacherUpdate');

    
//CHAPTER
Route::get('chapter/{id}', ([ChapterController::class, 'chapter_teacherShow']))
    ->where('id', '[0-9]+')
    ->name('chapter_teacherShow');
Route::get('course/{id}/chapters/new', ([ChapterController::class, 'teacherCreate']))
    ->where('id', '[0-9]+')
    ->name('chapter_teacherCreate');

//ASSIGNMENT
Route::get('assignment/{id}', ([AssignmentController::class, 'assignment_teacherShow']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherShow');
Route::get('course/{id}/assignment/new', ([AssignmentController::class, 'teacherCreate']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherCreate');

//STUDENT
Route::get('students', ([StudentController::class, 'teacherIndex']))
    ->name('student_teacherIndex');
Route::post('students/search', ([StudentController::class, 'teacherSearch']))
    ->name('student_teacherSearch');
Route::post('students/store', ([StudentController::class, 'teacherStore']))
    ->name('student_teacherStore');
Route::get('students/{id}', ([StudentController::class, 'teacherShow']))
    ->where('id', '[0-9]+')
    ->name('student_teacherShow');
Route::post('students/delete', ([StudentController::class, 'teacherDelete']))
    ->name('student_teacherDelete');

//ENROLMENTS
Route::post('students', ([StudentController::class, 'teacherStore']))
    ->name('student_teacherStore');



Route::get('plans', ([PlanController::class, 'teacherIndex']))
    ->name('plan_teacherIndex');
Route::get('subscriptions/payment_failed', ([SubscriptionController::class, 'teacherFail']))
    ->name('subscription_teacherFail');
Route::post('create-checkout-session', ([SubscriptionController::class, 'createCheckoutSession']))
    ->name('create-checkout-session');
