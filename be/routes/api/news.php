<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{news}', [NewsController::class, 'getById']);
    Route::post('/news', [NewsController::class, 'store']);
    Route::put('/news/{news}', [NewsController::class, 'update']);
    Route::delete('/news/{news}', [NewsController::class, 'destroy']);
});

Route::get('/news-references', [NewsController::class, 'getReferences']);
Route::get('/news-reference/{slug}', [NewsController::class, 'getBySlug']);

