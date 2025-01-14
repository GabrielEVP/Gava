<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TypePaymentController;
use App\Http\Controllers\Api\TypePriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('companies', CompanyController::class);
    Route::resource('/clients', ClientController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/typePayments', TypePaymentController::class);
    Route::resource('/typePrices', TypePriceController::class);
    Route::resource('/supplier', SupplierController::class);
    Route::resource('/order', OrderController::class);
    Route::resource('/invoices', InvoiceController::class);

    Route::get('/clients/search/{query}', [ClientController::class, 'search']);
    Route::get('/suppliers/search/{query}', [SupplierController::class, 'search']);
});
