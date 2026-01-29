<?php

use App\Http\Controllers\api\ApiProductController;
use App\Http\Controllers\api\ApiTransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::resource('products', ApiProductController::class)->only([
    'index','store'
]);

Route::post('/transaction/insert',[ApiTransactionController::class, 'store']);