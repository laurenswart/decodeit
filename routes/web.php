<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//ADMIN
Route::get('/admin/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/admin/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');


require __DIR__.'/auth.php';

