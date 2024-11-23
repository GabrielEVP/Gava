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
        Schema::create('invoice_due_dates', function (Blueprint $table) {
            $table->id();
            $table->date('due_date'); // Fecha de vencimiento
            $table->decimal('amount', 10, 2); // Monto adeudado para la fecha de vencimiento
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending'); // Estado del vencimiento
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id'); // ID de la factura

            // Clave foránea
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_due_dates');
    }
};
