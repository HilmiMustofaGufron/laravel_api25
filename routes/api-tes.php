<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::prefix('v1')->group(function () {
    Route::resource('products', ProductController::class);
    

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products-store', [ProductController::class, 'store']);
});