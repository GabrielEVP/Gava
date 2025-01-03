<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamp('invoice_date');
            $table->decimal('total_amount', 10, 2);
            $table->string('status');
            $table->string('frequency');
            $table->timestamp('next_invoice_date');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('recurring_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recurring_invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
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
