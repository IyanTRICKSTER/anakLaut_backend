<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/payment/token', [\App\Http\Controllers\API\TransactionController::class, 'token'])->name('api.payment.token');
Route::post('/v1/payment/finish', [\App\Http\Controllers\API\TransactionController::class, 'finish'])->name('api.payment.finish');
Route::post('/v1/payment/notification', [\App\Http\Controllers\API\TransactionController::class, 'notification'])->name('api.payment.notification');