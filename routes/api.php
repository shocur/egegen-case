<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware(['bearer.token', 'log.request'])->group(function () {
    Route::apiResource('/news', \App\Http\Controllers\Api\NewsController::class);
});