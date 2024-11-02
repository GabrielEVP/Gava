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
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date'); // Fecha de pago
            $table->decimal('amount', 10, 2); // Monto del pago
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id'); // ID de la factura
            $table->unsignedBigInteger('type_payment_id'); // ID del tipo de pago

            // Claves foráneas
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
