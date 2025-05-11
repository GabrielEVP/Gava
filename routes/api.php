<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TypePaymentController;
use App\Http\Controllers\Api\TypePriceController;
use App\Http\Controllers\Api\ProfileImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile_images/{filename}', [ProfileImageController::class, 'show']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::put('/user/update', [AuthController::class, 'update']);

    Route::resource('/categories', CategoryController::class);
    Route::resource('/clients', ClientController::class);
    Route::resource('/invoices', InvoiceController::class);
    Route::resource('/orders', OrderController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/purchases', PurchaseController::class);
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/type-payments', TypePaymentController::class);
    Route::resource('/type-prices', TypePriceController::class);

    Route::get('/clients/search/{query}', [ClientController::class, 'search']);
    Route::get('/suppliers/search/{query}', [SupplierController::class, 'search']);

    Route::put('/purchases/paid/{id}', [PurchaseController::class, 'paidPurchaseAndDeliveredProducts']);

    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download']);
});
