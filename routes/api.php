<?php

use App\Http\Controllers\AuthController;
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

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']); // Register Route
Route::post('/auth/login', [AuthController::class, 'login']); // Login Route

// Token protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/me', function (Request $request) {
        return auth()->user();
    });

    // Intern routes
    Route::get('/interns', [\App\Http\Controllers\InternController::class, 'index']);
    Route::get('/interns/{intern}', [\App\Http\Controllers\InternController::class, 'show']);
    Route::delete('/interns/{intern}', [\App\Http\Controllers\InternController::class, 'destroy']);
    Route::post('/interns', [\App\Http\Controllers\InternController::class, 'store']);

    // Group routes
    Route::get('/groups', [\App\Http\Controllers\GroupController::class, 'index']);
    Route::get('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'show']);
    Route::delete('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'destroy']);
    Route::post('/groups', [\App\Http\Controllers\GroupController::class, 'store']);

    // Assignment routes
    Route::get('/assignments', [\App\Http\Controllers\AssignmentController::class, 'index']);
    Route::get('/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'show']);
    Route::delete('/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'destroy']);
    Route::post('/assignments', [\App\Http\Controllers\AssignmentController::class, 'store']);

    // Mentor routes
    Route::get('/mentors', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/mentors/{user}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::delete('/mentors/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
    Route::post('/mentors', [\App\Http\Controllers\UserController::class, 'store']);

    // Review routes
    Route::get('/interns/{intern}/assignments', [\App\Http\Controllers\ReviewController::class, 'index']);
    Route::get('/interns/{intern}/assignments/{review}', [\App\Http\Controllers\ReviewController::class, 'show']);
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy']);
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store']);

    // Routes only Admin can access
    Route::group(['middleware' => ['role:admin']], function () {
        //
    });

    // Routes only Recruiter can access
    Route::group(['middleware' => ['role:recruiter']], function () {
        //
    });

    // Routes only Mentor can access
    Route::group(['middleware' => ['role:mentor']], function () {
        //
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']); // Logout route
});
