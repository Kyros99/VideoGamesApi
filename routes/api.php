<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register',[UserAuthController::class,'register']);

Route::post('/login', [UserAuthController::class, 'login'])
    ->middleware('throttle:10,1');

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::apiResource('games', GameController::class);

    Route::post('/games/{game}/rate', [RatingController::class, 'store']);
    Route::get('/games/{game}/ratings', [RatingController::class, 'show']);

    Route::post('/games/{game}/review', [ReviewController::class, 'store']);
    Route::get('/games/{game}/reviews', [ReviewController::class, 'show']);
});



