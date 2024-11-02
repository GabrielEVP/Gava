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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Número de la factura
            $table->date('issue_date'); // Fecha de emisión
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending'); // Estado de la factura
            $table->timestamps();
            $table->unsignedBigInteger('client_id'); // ID del cliente
            $table->unsignedBigInteger('company_id'); // ID de la empresa

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
        Schema::dropIfExists('envoices');
    }
};
