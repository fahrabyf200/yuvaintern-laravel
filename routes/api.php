<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']);
Route::post('/products', [App\Http\Controllers\Api\ProductController::class, 'store']);
Route::get('/products/{product}', [App\Http\Controllers\Api\ProductController::class, 'show']);
Route::put('/products/{product}', [App\Http\Controllers\Api\ProductController::class, 'update']);
Route::delete('/products/{product}', [App\Http\Controllers\Api\ProductController::class, 'destroy']);