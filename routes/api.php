<?php

use App\Http\Controllers\api\ApiProductController;
use App\Http\Controllers\api\ApiTransactionController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ApiProductController::class, 'getListPaginated']);

Route::post('/transaction/insert',[ApiTransactionController::class, 'store']);