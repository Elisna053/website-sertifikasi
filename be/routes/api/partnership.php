<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnershipController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/partnerships', [PartnershipController::class, 'index']);
    Route::post('/partnerships', [PartnershipController::class, 'store']);
    Route::put('/partnerships/{partnership}', [PartnershipController::class, 'update']);
    Route::delete('/partnerships/{partnership}', [PartnershipController::class, 'destroy']);
});

Route::get('/partnerships-references', [PartnershipController::class, 'getReferences']);