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

    Route::resource('/interns', \App\Http\Controllers\InternController::class, ['only' => ['index','store', 'show', 'update', 'destroy']]);

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
