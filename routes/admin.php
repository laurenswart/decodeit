<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;



//Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
    // Admin Dashboard
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('adminDashboard');	
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('adminLogout');
//});

