<?php

use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\api\ApiProductController;
use App\Http\Controllers\api\ApiTransactionController;
use App\Http\Controllers\api\ApiUnitController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ApiProductController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy'
    ]);

    Route::resource('units', ApiUnitController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy'
    ]);

    Route::post('/transaction/insert', [ApiTransactionController::class, 'store']);

    Route::post('logout', [ApiAuthController::class, 'logout']);
});
