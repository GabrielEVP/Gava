<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->string('description'); // Descripción de la línea de la factura
            $table->integer('quantity'); // Cantidad del producto
            $table->decimal('unit_price', 10, 2); // Precio unitario
            $table->decimal('tax_rate', 5, 2)->default(0.00); // Tasa de impuesto
            $table->decimal('total', 10, 2); // Total de la línea
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id'); // ID de la factura
            $table->unsignedBigInteger('product_id')->nullable(); // ID del producto (opcional)

            // Claves foráneas
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_lines');
    }
};
