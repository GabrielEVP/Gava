<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('concept');
            $table->date('date');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('next_invoice_date');
            $table->timestamps();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('recurring_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('vat_rate', 10, 2);
            $table->decimal('total_amount', 10, 2)->generatedAs('quantity * unit_price)');
            $table->decimal('total_amount_rate', 10, 2)->generatedAs('quantity * unit_price * (1 + vat_rate / 100)');
            $table->timestamps();
            $table->unsignedBigInteger('recurring_invoice_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('recurring_invoice_id')->references('id')->on('recurring_invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_invoice_lines');
        Schema::dropIfExists('recurring_invoices');
    }
};
