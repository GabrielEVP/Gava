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
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamp('payment_date'); // Fecha del pago
            $table->decimal('amount', 10, 2); // Monto del pago
            $table->timestamps();
            $table->unsignedBigInteger('purchase_id'); // Clave foránea que referencia a la tabla purchases
            $table->unsignedBigInteger('type_payment_id'); // Clave foránea que referencia a la tabla type_payments

            // Claves foráneas
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_payments');
    }
};
