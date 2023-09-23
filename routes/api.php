<?php

use App\Http\Controllers\{CartController, PaymentController, ProductController};
use App\Http\Controllers\Auth\{GuestController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [GuestController::class, 'register']);
Route::post('login', [GuestController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('products', ProductController::class)->except('show');
    Route::post('add-to-cart', [CartController::class, 'addToCart']);

    Route::prefix('payment')->group(function () {
        Route::get('initiate', [PaymentController::class, 'initiate']);
        Route::get('success', [PaymentController::class, 'success']);
        Route::get('failed', [PaymentController::class, 'failed']);
    });
});
