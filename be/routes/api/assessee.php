<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssesseeController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/assessee', [AssesseeController::class, 'index']);
    Route::get('/assessee/statistic-detail', [AssesseeController::class, 'statisticDetail']);
    Route::get('/assessee/{assessee}', [AssesseeController::class, 'getById']);
    Route::post('/assessee', [AssesseeController::class, 'store']);
    Route::put('/assessee/{assessee}', [AssesseeController::class, 'update']);
    Route::delete('/assessee/{assessee}', [AssesseeController::class, 'destroy']);
    Route::get('assessee/reference-by-status/approved', [AssesseeController::class, 'approvedAssessee']);
    Route::get('assessee/template/download/apl01', [AssesseeController::class, 'downloadApl01Template']);
    Route::get('assessee/template/download/apl02', [AssesseeController::class, 'downloadApl02Template']);
    Route::put('assessee/{assessee}/status', [AssesseeController::class, 'updateStatus']);
});
