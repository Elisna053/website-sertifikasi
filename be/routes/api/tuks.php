<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TuksController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tuks', [TuksController::class, 'index']);
    Route::get('/tuks/{tuks}', [TuksController::class, 'getTuks']);
    Route::post('/tuks', [TuksController::class, 'store']);
    Route::put('/tuks/{tuks}', [TuksController::class, 'update']);
    Route::delete('/tuks/{tuks}', [TuksController::class, 'destroy']);
});

// public routes
Route::get('/tuks-references', [TuksController::class, 'getReferences']);
Route::get('/tuks/{tuksReference}/details', [TuksController::class, 'getReferenceDetails']);
