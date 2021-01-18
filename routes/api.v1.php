<?php

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

Route::post('users', [\App\Domains\Users\Controllers\UserController::class, 'store'])
    ->name('users.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', \App\Domains\Users\Controllers\UserController::class)
        ->only('update', 'destroy');

    Route::post('/transaction', [\App\Domains\Transactions\Controllers\TransactionController::class, 'store'])
        ->name('transaction.send');

    Route::delete('/users/{user}/transactions/{transaction}', [\App\Domains\Transactions\Controllers\TransactionController::class, 'destroy'])
        ->name('transaction.revert');
});
