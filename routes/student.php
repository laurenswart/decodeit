<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StudentAssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubmissionController;
use App\Models\Chapter;
use App\Models\StudentAssignment;
use Illuminate\Support\Facades\Route;


//GENERAL
Route::get('dashboard', ([StudentController::class, 'dashboard']))
    ->name('studentDashboard');
Route::get('progress', ([StudentController::class, 'studentProgress']))
    ->name('studentProgress');
Route::get('account', ([StudentController::class, 'studentShow']))
    ->name('student_studentShow');
Route::get('account/edit', ([StudentController::class, 'studentEdit']))
    ->name('student_studentEdit');
Route::post('account', ([StudentController::class, 'studentUpdate']))
    ->name('student_studentUpdate');
Route::get('account/delete', ([StudentController::class, 'studentConfirmDelete']))
    ->name('student_confirmDelete');
Route::delete('account/delete', ([StudentController::class, 'studentDelete']))
    ->name('student_studentDelete');

//COURSE
Route::get('courses', ([CourseController::class, 'studentIndex']))
    ->name('course_studentIndex');
Route::get('courses/{id}', ([CourseController::class, 'studentShow']))
    ->where('id', '[0-9]+')
    ->name('course_studentShow');
Route::get('courses/{id}/progress', ([CourseController::class, 'studentProgress']))
    ->where('id', '[0-9]+')
    ->name('course_studentProgress');

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

//STUDENT ASSIGNMENT
Route::get('studentAssignment/{id}/done', ([StudentAssignmentController::class, 'studentConfirmDone']))
    ->where('id', '[0-9]+')
    ->name('studentAssignment_studentConfirmDone');
Route::post('studentAssignment/{id}/done', ([StudentAssignmentController::class, 'studentDone']))
    ->where('id', '[0-9]+')
    ->name('studentAssignment_studentDone');
Route::get('assignments/{id}/testscript', ([AssignmentController::class, 'studentTestScript']))
    ->where('id', '[0-9]+')
    ->name('assignment_studentTestScript');
//SUBMISSION
Route::post('assignments/{id}', ([SubmissionController::class, 'studentStore']))
    ->where('id', '[0-9]+')
    ->name('submission_studentStore');
Route::post('submission/{id}/addQuestion', ([SubmissionController::class, 'studentAddQuestion']))
    ->where('id', '[0-9]+')
    ->name('submission_studentAddQuestion');

//FORUM
Route::get('courses/{id}/forum', ([MessageController::class, 'studentForum']))
    ->where('id', '[0-9]+')
    ->name('message_studentForum');
Route::post('courses/{id}/forum', ([MessageController::class, 'store']))
    ->where('id', '[0-9]+')
    ->name('message_store');

    