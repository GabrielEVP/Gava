<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ExpenseTypeController;
use App\Http\Controllers\api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SupplierCategoryController;
use App\Http\Controllers\Api\TypePaymentController;
use App\Http\Controllers\Api\TypePriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::resource('companies', CompanyController::class);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::resource('{company_id}/clients', ClientController::class);
    Route::resource('{company_id}/products', ProductController::class);
    Route::resource('{company_id}/typePrices', TypePriceController::class);
    Route::resource('{company_id}/productCategories', ProductCategoryController::class);
    Route::resource('{company_id}/supplierCategory', SupplierCategoryController::class);
    Route::resource('{company_id}/supplier', SupplierController::class);
    Route::resource('{company_id}/expenseType', ExpenseTypeController::class);
    Route::resource('{company_id}/order', OrderController::class);
    Route::resource('{company_id}/invoices', InvoiceController::class);
    Route::resource('{company_id}/typePayments', TypePaymentController::class);
});


