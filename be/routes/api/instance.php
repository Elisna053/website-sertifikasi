<?php

use App\Http\Controllers\InstanceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/instances', [InstanceController::class, 'index']);
    Route::post('/instances', [InstanceController::class, 'store']);
    Route::put('/instances/{instance}', [InstanceController::class, 'update']);
    Route::delete('/instances/{instance}', [InstanceController::class, 'destroy']);

    Route::get('/instances/{instanceId}/jadwal', [InstanceController::class, 'jadwalIndex']);
    Route::post('/instances/jadwal', [InstanceController::class, 'jadwalStore']);
    Route::delete('/instances/{jadwalId}/jadwal', [InstanceController::class, 'jadwalDestroy']);


    Route::post('/apl_upload', [InstanceController::class, 'storeAplUpload']);

});

Route::get('/instances-reference', [InstanceController::class, 'getInstancesReference']);
Route::get('/instances_by_id/{id}', [InstanceController::class, 'getById']);
Route::get('/instances-jadwal-reference/{instnceId}', [InstanceController::class, 'getJadwalRefrences']);
Route::get('/get_unit_by_id_ass/{asId}', [InstanceController::class, 'getUnitByIdAss']);
