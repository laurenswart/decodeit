<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Plan;
use App\Models\Teacher;
use Illuminate\Http\Request;
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
    $plans = Plan::all()->where('is_custom','0')->where('title','!=', 'free');
    return view('welcome', ['plans'=>$plans]);
})->name('welcome');
Route::get('/plans', [PlanController::class, 'guestIndex'])->name('plans');

//ADMIN
Route::get('/admin/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/admin/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');


//STRIPE
Route::get('/billing-portal', function (Request $request) {
    Teacher::find(Auth::id())->createOrGetStripeCustomer();
    return Teacher::find(Auth::id())->redirectToBillingPortal(route('teacherDashboard'));
})->name('billingPortal');


Route::stripeWebhooks('webhook');

require __DIR__.'/auth.php';

