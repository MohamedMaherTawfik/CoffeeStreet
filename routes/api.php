<?php

use App\Http\Controllers\api\admin\productController;
use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\cart\cartController;
use App\Http\Middleware\ownCart;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('jwt.auth');
    Route::post('me', [AuthController::class, 'me'])->middleware('jwt.auth');
});

Route::controller(productController::class)->group(function () {
    Route::get('products', 'index');
    Route::get('products/{id}', 'show');
    Route::post('products', 'store');
    Route::post('products/{id}', 'update');
    Route::delete('products/{id}', 'destroy');
});


Route::controller(cartController::class)->group(function () {
    Route::post('/product/{id}/cart', 'addToCart');
    Route::get('/cart', 'getCartItems');
    Route::delete('/product/{id}/cart', 'deleteFromCart')->middleware(ownCart::class);
    Route::delete('/cart/clear', 'clearCart')->middleware(ownCart::class);
});
