<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'number');
            $table->date(column: 'date');
            $table->enum('status', allowed: ['pending', 'paid', 'overdue'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax_rate', 10, 2);
            $table->decimal('total_amount', 10, 2)->generatedAs('quantity * unit_price)');
            $table->decimal('total_amount_rate', 10, 2)->generatedAs('quantity * unit_price * (1 + tax_rate / 100)');
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });

        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('type_payment_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onDelete('restrict');
        });

        Schema::create('invoice_due_dates', function (Blueprint $table) {
            $table->id();
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
        Schema::dropIfExists('invoice_due_dates');
        Schema::dropIfExists('invoice_lines');
        Schema::dropIfExists('invoices');
    }
};
