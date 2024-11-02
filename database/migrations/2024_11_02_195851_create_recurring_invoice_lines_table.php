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
        Schema::create('recurring_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recurring_invoice_id'); // Clave foránea que referencia a la tabla recurring_invoices
            $table->unsignedBigInteger('product_id'); // Clave foránea que referencia a la tabla products
            $table->integer('quantity'); // Cantidad del producto
            $table->decimal('unit_price', 10, 2); // Precio unitario del producto
            $table->decimal('total_price', 10, 2); // Precio total (quantity * unit_price)
            $table->timestamps();

            // Claves foráneas
            $table->foreign('recurring_invoice_id')->references('id')->on('recurring_invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_invoice_lines');
    }
};
