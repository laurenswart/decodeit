<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentNoteController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrolmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StudentAssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TypeaheadController;
use App\Models\AssignmentNote;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//GENERAL
Route::get('dashboard', ([TeacherController::class, 'dashboard']))
    ->name('teacherDashboard');
Route::get('account', ([TeacherController::class, 'account']))
    ->name('teacher_account');
Route::get('account/edit', ([TeacherController::class, 'teacherEdit']))
    ->name('teacher_teacherEdit');
Route::post('account', ([TeacherController::class, 'teacherUpdate']))
    ->name('teacher_teacherUpdate');
Route::get('account/delete', ([TeacherController::class, 'teacherConfirmDelete']))
    ->name('teacher_confirmDelete');
Route::delete('account/delete', ([TeacherController::class, 'teacherDelete']))
    ->name('teacher_delete');

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
Route::get('courses/{id}/delete', ([CourseController::class, 'teacherConfirmDelete']))
    ->name('course_teacherConfirmDelete');
Route::delete('courses/{id}/delete', ([CourseController::class, 'teacherDelete']))
    ->name('course_teacherDelete');

Route::get('courses/{id}/report/download', ([CourseController::class, 'teacherDownloadReports']))
    ->where('id', '[0-9]+')
    ->name('course_teacherDownloadReports');
//CHAPTER
Route::get('chapters/{id}', ([ChapterController::class, 'teacherShow']))
    ->where('id', '[0-9]+')
    ->name('chapter_teacherShow');
Route::get('courses/{id}/chapters/new', ([ChapterController::class, 'teacherCreate']))
    ->where('id', '[0-9]+')
    ->name('chapter_teacherCreate');
Route::post('courses/{id}/chapters', ([ChapterController::class, 'teacherStore']))
    ->name('chapter_teacherStore');
Route::get('chapters/{id}/edit', ([ChapterController::class, 'teacherEdit']))
    ->where('id', '[0-9]+')
    ->name('chapter_teacherEdit');
Route::post('chapters/{id}', ([ChapterController::class, 'teacherUpdate']))
    ->name('chapter_teacherUpdate');  
Route::get('chapters/{id}/delete', ([ChapterController::class, 'teacherConfirmDelete']))
    ->name('chapter_teacherConfirmDelete');
Route::delete('chapters/{id}/delete', ([ChapterController::class, 'teacherDelete']))
    ->name('chapter_teacherDelete');
    
//ASSIGNMENT
Route::get('assignments/{id}', ([AssignmentController::class, 'teacherShow']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherShow');
Route::get('chapters/{id}/assignments/new', ([AssignmentController::class, 'teacherCreate']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherCreate');
Route::post('chapters/{id}/assignments', ([AssignmentController::class, 'teacherStore']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherStore');
Route::get('assignments/{id}/edit', ([AssignmentController::class, 'teacherEdit']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherEdit');
Route::post('assignments/{id}', ([AssignmentController::class, 'teacherUpdate']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherUpdate');
Route::get('assignments/{id}/delete', ([AssignmentController::class, 'teacherConfirmDelete']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherConfirmDelete');
Route::delete('assignments/{id}/delete', ([AssignmentController::class, 'teacherDelete']))
    ->where('id', '[0-9]+')
    ->name('assignment_teacherDelete');

//ASSIGNMENT NOTES
Route::get('assignments/{id}/notes/new', ([AssignmentNoteController::class, 'teacherCreate']))
    ->where('id', '[0-9]+')
    ->name('assignmentNote_teacherCreate');
Route::post('assignments/{id}/notes/new', ([AssignmentNoteController::class, 'teacherStore']))
    ->where('id', '[0-9]+')
    ->name('assignmentNote_teacherStore');

//STUDENT ASSIGNMENTS
Route::get('studentAssignment/{id}', ([StudentAssignmentController::class, 'teacherShow']))
    ->where('id', '[0-9]+')
    ->name('studentAssignment_teacherShow');
Route::post('submissions/{id}/updateFeedback', ([SubmissionController::class, 'teacherUpdateFeedback']))
    ->where('id', '[0-9]+')
    ->name('submission_teacherUpdateFeedback');
Route::get('studentAssignment/{id}/mark', ([StudentAssignmentController::class, 'teacherEditMark']))
    ->where('id', '[0-9]+')
    ->name('studentAssignment_teacherEditMark');
Route::post('studentAssignment/{id}', ([StudentAssignmentController::class, 'teacherUpdateMark']))
    ->where('id', '[0-9]+')
    ->name('studentAssignment_teacherUpdateMark');

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
Route::get('students/{id}/delete', ([StudentController::class, 'teacherConfirmDelete']))
    ->where('id', '[0-9]+')
    ->name('student_teacherConfirmDelete');
Route::delete('students/{id}/delete', ([StudentController::class, 'teacherDelete']))
    ->where('id', '[0-9]+')
    ->name('student_teacherDelete');

Route::post('students', ([StudentController::class, 'teacherStore']))
    ->name('student_teacherStore');
Route::get('students/{id}/report/download', ([StudentController::class, 'teacherDownloadReport']))
    ->where('id', '[0-9]+')
    ->name('student_teacherDownloadReport');

//ENROLMENTS
Route::get('enrolments/{id}/delete', ([EnrolmentController::class, 'teacherConfirmDelete']))
    ->name('enrolment_teacherConfirmDelete');
Route::delete('enrolments/{id}/delete', ([EnrolmentController::class, 'teacherDelete']))
    ->name('enrolment_teacherDelete');


//SKILLS
Route::get('skills/{id}/delete', ([SkillController::class, 'teacherConfirmDelete']))
    ->name('skill_teacherConfirmDelete');
Route::delete('skills/{id}/delete', ([SkillController::class, 'teacherDelete']))
    ->name('skill_teacherDelete');
Route::get('students/{id}/skill/{nb}', ([SkillController::class, 'editStudentMark']))
    ->where('id', '[0-9]+')
    ->where('nb', '[0-9]+')
    ->name('studentSkill_teacherEdit');
Route::post('students/{id}/skill/{nb}', ([SkillController::class, 'updateStudentMark']))
    ->where('id', '[0-9]+')
    ->where('nb', '[0-9]+')
    ->name('studentSkill_teacherUpdate');


Route::get('plans', ([PlanController::class, 'teacherIndex']))
    ->name('plan_teacherIndex');
Route::get('subscriptions/payment_failed', ([SubscriptionController::class, 'teacherFail']))
    ->name('subscription_teacherFail');
Route::post('create-checkout-session', ([SubscriptionController::class, 'createCheckoutSession']))
    ->name('create-checkout-session');

//TYPEAHEAD
Route::post('/searchMyStudents', [TypeaheadController::class, 'newEnrolmentByTeacher'])
    ->name('search_newEnrolmentByTeacher');

//FORUM
Route::get('courses/{id}/forum', ([MessageController::class, 'teacherForum']))
->where('id', '[0-9]+')
->name('message_teacherForum');
Route::post('courses/{id}/forum', ([MessageController::class, 'store']))
->where('id', '[0-9]+')
->name('message_teacherStore');

