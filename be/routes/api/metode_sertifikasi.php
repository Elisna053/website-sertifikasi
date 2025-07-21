<?php

use App\Http\Controllers\MetodeSertifikasiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/metodes', [MetodeSertifikasiController::class, 'index']);
    Route::post('/metodes', [MetodeSertifikasiController::class, 'store']);
    Route::delete('/metodes/{id}', [MetodeSertifikasiController::class, 'destroy']);
});

// public routes
Route::get('/metode/{id}', [MetodeSertifikasiController::class, 'getDataById']);
Route::get('/metode_sertifikasi_references', [MetodeSertifikasiController::class, 'getReferences']);
Route::get('/metode_sertifikasi/{id}', [MetodeSertifikasiController::class, 'getReferencesById']);
