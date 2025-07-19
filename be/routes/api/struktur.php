<?php

use App\Http\Controllers\StrukturController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/struktur', [StrukturController::class, 'index']);
    Route::post('/struktur', [StrukturController::class, 'store']);
    Route::put('/struktur/{id}', [StrukturController::class, 'update']);
    Route::delete('/struktur/{id}', [StrukturController::class, 'destroy']);
});

// public routes
Route::get('/struktur-references', [StrukturController::class, 'getReferences']);
