<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/callback', [PaymentController::class, 'paymentCallback']);

Route::post('/sendsms', [PaymentController::class, 'smstest']);
