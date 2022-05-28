<?php

use App\Http\Controllers\ApiController;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [ApiController::class, 'user'])->name('api.user');

    Route::get('courses', [ApiController::class, 'courses'])->name('api.courses');

    Route::get('courses/{id}/chapters', [ApiController::class, 'chapters'])->name('api.chapters');

    Route::get('courses/{id}/assignments', [ApiController::class, 'assignmentsByCourse'])->name('api.assignmentsByCourse');

    Route::get('chapters/{id}/assignments', [ApiController::class, 'assignmentsByChapter'])->name('api.assignmentsByChapter');
});

/**
 * Route to generate an api token for testing user
 */
Route::get('/token/create', function () {
    $user = Student::where('email', 'lswart@gmail.com')->first();
    $user->tokens()->delete();
    $token = $user->createToken('student_api_key');
    var_dump($token->plainTextToken);
});