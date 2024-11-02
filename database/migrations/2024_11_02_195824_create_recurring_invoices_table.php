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
        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // Clave foránea que referencia a la tabla clients
            $table->unsignedBigInteger('company_id'); // Clave foránea que referencia a la tabla companies
            $table->timestamp('invoice_date'); // Fecha de la factura
            $table->decimal('total_amount', 10, 2); // Monto total de la factura
            $table->string('status'); // Estado de la factura (por ejemplo, pendiente, pagada, cancelada)
            $table->string('frequency'); // Frecuencia de la factura (por ejemplo, mensual, trimestral)
            $table->timestamp('next_invoice_date'); // Fecha de la próxima factura
            $table->timestamps();

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
        Schema::dropIfExists('recurring_invoices');
    }
};
