<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\SchemaUnitController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/schemas', [SchemaController::class, 'index']);
    Route::get('/schemas/{schema}', [SchemaController::class, 'getSchema']);
    Route::post('/schemas', [SchemaController::class, 'store']);
    Route::put('/schemas/{schema}', [SchemaController::class, 'update']);
    Route::delete('/schemas/{schema}', [SchemaController::class, 'destroy']);

    // schema unit
    Route::post('/schema-units', [SchemaUnitController::class, 'store']);
    Route::put('/schema-units/{schemaUnit}', [SchemaUnitController::class, 'update']);
    Route::delete('/schema-units/{schemaUnit}', [SchemaUnitController::class, 'destroy']);
});

// public routes
Route::get('/schemas-references', [SchemaController::class, 'getReferences']);
Route::get('/schemas/{schemaReference}/details', [SchemaController::class, 'getReferenceDetails']);
