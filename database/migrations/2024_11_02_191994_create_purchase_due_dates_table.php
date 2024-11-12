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
        Schema::create('purchase_due_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id'); // Clave foránea que referencia a la tabla purchases
            $table->timestamp('due_date'); // Fecha de vencimiento del pago
            $table->decimal('amount', 10, 2); // Monto a pagar en esta fecha
            $table->timestamps();

            // Clave foránea
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_due_dates');
    }
};
