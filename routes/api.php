<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('cart/count', [ApiCartController::class, 'count'])->name('cart.count');
    Route::put('cart/decrease/{rowId}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
    Route::put('cart/increase/{rowId}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
    Route::apiResource('cart', ApiCartController::class);
});


