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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamp('purchase_date'); // Fecha de la compra
            $table->decimal('total_amount', 10, 2); // Monto total de la compra
            $table->string('status'); // Estado de la compra (pendiente, completada, cancelada)
            $table->timestamps();
            $table->unsignedBigInteger('supplier_id'); // Clave foránea que referencia a la tabla suppliers
            $table->unsignedBigInteger('company_id'); // Clave foránea que referencia a la tabla companies

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
