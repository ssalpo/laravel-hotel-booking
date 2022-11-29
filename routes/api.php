<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], static function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::group(['middleware' => 'auth:api'], static function () {
    Route::post('/bookings/{booking}/change-status', [BookingController::class, 'changeStatus']);
    Route::apiResource('bookings', BookingController::class);

    Route::get('/rooms', [RoomController::class, 'index']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}/bookings', [UserController::class, 'bookings']);
});
