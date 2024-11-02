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
        Schema::create('recurring_expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamp('expense_date'); // Fecha del gasto
            $table->decimal('amount', 10, 2); // Monto del gasto
            $table->string('description'); // Descripción del gasto
            $table->timestamps();
            $table->unsignedBigInteger('company_id'); // Clave foránea que referencia a la tabla companies
            $table->unsignedBigInteger('type_expense_id'); // Clave foránea que referencia a la tabla expense_types

            // Claves foráneas
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('type_expense_id')->references('id')->on('expense_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_expenses');
    }
};
