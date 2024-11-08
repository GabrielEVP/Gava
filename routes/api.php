<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('products', ProductController::class);
    Route::resource('companies', CompanyController::class);

    Route::get('logout', [AuthController::class, 'logout']);
});


