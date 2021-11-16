<?php

use App\Http\Controllers\AuthController;
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
Route::post('/auth/login', [AuthController::class, 'login']); // Login Route

// Token protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Intern routes
    Route::get('/interns', [\App\Http\Controllers\InternController::class, 'index']);
    Route::get('/interns/{intern}', [\App\Http\Controllers\InternController::class, 'show']);

    // Group routes
    Route::patch('/groups/{group}/assignments/{assignment}/activate', [\App\Http\Controllers\GroupController::class, 'activateAssignment']);
    Route::patch('/groups/{group}/assignments/{assignment}/deactivate', [\App\Http\Controllers\GroupController::class, 'deactivateAssignment']);
    Route::post('/groups/{group}/assignments/{assignment}/add', [\App\Http\Controllers\GroupController::class, 'addAssignment']);

    // Assignment routes
    Route::get('/assignments', [\App\Http\Controllers\AssignmentController::class, 'index']);
    Route::get('/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'show']);
    Route::delete('/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'destroy']);
    Route::put('/assignments/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'update']);

    // Mentor routes
    Route::get('/mentors', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/mentors/{user}', [\App\Http\Controllers\UserController::class, 'show']);

    // Review routes
    Route::get('/interns/{intern}/assignments', [\App\Http\Controllers\ReviewController::class, 'index']);
    Route::get('/interns/{intern}/assignments/{review}', [\App\Http\Controllers\ReviewController::class, 'show']);


    // Routes only Admin can access
    Route::group(['middleware' => ['role:admin']], function () {

        Route::post('/users/{user}/roles', [\App\Http\Controllers\UserController::class, 'changeRole']);
        Route::delete('/mentors/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
        Route::put('/mentors/{user}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('/interns/{intern}', [\App\Http\Controllers\InternController::class, 'destroy']);
        Route::put('/interns/{intern}', [\App\Http\Controllers\InternController::class, 'update']);

    });

    // Routes only Recruiter can access
    Route::group(['middleware' => ['role:admin|recruiter']], function () {

        Route::post('/mentors', [\App\Http\Controllers\UserController::class, 'store']);
        Route::post('/groups', [\App\Http\Controllers\GroupController::class, 'store']);
        Route::delete('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'destroy']);
        Route::put('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'update']);

    });

    // Routes ony Mentor can access
    Route::group(['middleware' => ['role:admin|mentor']], function () {

        Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy']);

    });

    //Routes all users can access (admins, mentors and recruiters)
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store']);
    Route::post('/interns', [\App\Http\Controllers\InternController::class, 'store']);
    Route::get('/groups', [\App\Http\Controllers\GroupController::class, 'index']);
    Route::get('/groups/{group}', [\App\Http\Controllers\GroupController::class, 'show']);
    Route::post('/assignments', [\App\Http\Controllers\AssignmentController::class, 'store']);

    Route::post('/auth/logout', [AuthController::class, 'logout']); // Logout route
});
