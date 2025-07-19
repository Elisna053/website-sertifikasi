<?php

use App\Http\Controllers\AssessorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/assessor', [AssessorController::class, 'index']);
    Route::post('/assessor', [AssessorController::class, 'store']);
    Route::put('/assessor/{gallery}', [AssessorController::class, 'update']);
    Route::delete('/assessor/{gallery}', [AssessorController::class, 'destroy']);
});

// public routes
Route::get('/assessor-references', [AssessorController::class, 'getReferences']);
