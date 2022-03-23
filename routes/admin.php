<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



//Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
    // Admin Dashboard
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('adminDashboard');	
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('adminLogout');
    Route::get('subscriptions', [SubscriptionController::class, 'adminIndex'])
        ->name('adminSubscriptionsIndex');
    Route::get('subscriptions/{id}', [SubscriptionController::class, 'adminShow'])
        ->where('id', '[0-9]+')
        ->name('adminSubscriptionsShow');

    Route::get('users', [UserController::class, 'adminIndex'])
        ->name('adminUsersIndex');
    Route::get('users/deleted', [UserController::class, 'deletedAccounts'])
        ->name('adminUsersDeletedAccounts');

    Route::get('students', [StudentController::class, 'adminIndex'])
        ->name('adminStudentsIndex');
    Route::get('teachers', [TeacherController::class, 'adminIndex'])
        ->name('adminTeachersIndex');
//});

