<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index']);
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy']);
});

// public routes
Route::get('/galleries-references', [GalleryController::class, 'getReferences']);
