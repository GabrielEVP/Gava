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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('concept'); // Concepto del pedido
            $table->timestamp('order_date'); // Fecha del pedido
            $table->string('status'); // Estado del pedido (pendiente, completado, cancelado, etc.)
            $table->decimal('total_amount', 10, 2); // Monto total del pedido
            $table->timestamps();
            $table->unsignedBigInteger('client_id'); // Clave foránea que referencia a la tabla clients
            $table->unsignedBigInteger('company_id'); // Clave foránea que referencia a la tabla companies

            // Claves foráneas
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
