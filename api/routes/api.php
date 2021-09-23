<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('developers')->group(function () {
    Route::get('', [DeveloperController::class, 'index']);
    Route::get('{id}', [DeveloperController::class, 'edit']);
    Route::post('', [DeveloperController::class, 'store']);
    Route::put('{id}', [DeveloperController::class, 'update']);
    Route::delete('{id}', [DeveloperController::class, 'destroy']);
});
