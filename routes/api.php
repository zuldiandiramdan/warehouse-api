<?php

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/product', function () {
    return ProductResource::collection(Product::all());
});
