<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'number');
            $table->date(column: 'date');
            $table->enum(column: 'status', allowed: ['pending', 'paid', 'refused'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('total_tax_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax_rate', 10, 2);
            $table->decimal('total_amount', 10, 2)->generatedAs('quantity * unit_price)');
            $table->decimal('total_tax_amount', 10, 2)->generatedAs('quantity * unit_price * (1 + tax_rate / 100)');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on(table: 'purchases')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on(table: 'purchases')->onDelete('cascade');
            $table->unsignedBigInteger('type_payment_id');
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('purchase_due_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'refused'])->default('pending');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on(table: 'purchases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_payments');
        Schema::dropIfExists('purchase_due_dates');
        Schema::dropIfExists('purchase_lines');
        Schema::dropIfExists('purchases');
    }
};
