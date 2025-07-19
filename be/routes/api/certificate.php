<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/certificates', [CertificateController::class, 'index']);
    Route::get('/certificates/{certificate}', [CertificateController::class, 'getById']);
    Route::post('/certificates', [CertificateController::class, 'store']);
    Route::put('/certificates/{certificate}', [CertificateController::class, 'update']);
    Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy']);

    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'downloadCertificate']);
});
