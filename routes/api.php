<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/movies', MovieController::class);
    Route::apiResource('/ratings', RatingController::class);
});