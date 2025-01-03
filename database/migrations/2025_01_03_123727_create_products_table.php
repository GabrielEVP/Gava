<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('barcode')->nullable();
            $table->string('reference_code')->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('vat_rate', 5, 2)->default(0.00);
            $table->decimal('stock_quantity', 10, 2)->default(0);
            $table->integer('units_per_box')->default(1);
            $table->timestamps();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade')->nullable();
        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('type_price_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('type_price_id')->references('id')->on('type_prices')->onDelete('cascade');
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_prices');
        Schema::dropIfExists('products');
    }
};
