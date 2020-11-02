<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use \App\Http\Controllers\BranchController;
use \App\Http\Controllers\BookingController;
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

Route::get('booking/history', [BookingController::class, 'history'])->middleware('auth:api');
Route::patch('booking/{booking}/close', [BookingController::class, 'close'])->middleware('auth:api');

Route::prefix('api')->group(function (){
    Route::post('register', [UserController::class, 'store']);
    Route::post('login', [UserController::class, 'login']);
    Route::get('branch', [BranchController::class, 'index']);
    Route::post('booking', [BookingController::class, 'store']);
    Route::get('cars', [CarController::class, 'search']);

    Route::get('profile', [UserController::class, 'view'])->middleware('auth:api');
    Route::get('booking/active', [BookingController::class, 'active'])->middleware('auth:api');
    Route::get('booking/{booking}', [BookingController::class, 'view'])->middleware('auth:api');
});


