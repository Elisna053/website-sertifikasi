<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-details', [UserController::class, 'getUserDetails']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
});
