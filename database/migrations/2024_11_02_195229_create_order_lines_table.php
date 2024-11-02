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
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity'); // Cantidad de productos en esta línea de pedido
            $table->decimal('unit_price', 10, 2); // Precio por unidad del producto
            $table->decimal('total_price', 10, 2); // Precio total para esta línea (quantity * unit_price)
            $table->timestamps();
            $table->unsignedBigInteger('order_id'); // Clave foránea que referencia a la tabla orders
            $table->unsignedBigInteger('product_id'); // Clave foránea que referencia a la tabla products

            // Claves foráneas
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
