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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2); // Precio del producto
            $table->timestamps();
            $table->unsignedBigInteger('product_id'); // Clave foránea que referencia a la tabla products
            $table->unsignedBigInteger('type_price_id'); // Clave foránea que referencia a la tabla type_prices

            // Claves foráneas
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('type_price_id')->references('id')->on('type_prices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
