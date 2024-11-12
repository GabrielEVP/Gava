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
        Schema::create('type_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nombre del método de pago
            $table->string('description')->nullable(); // Descripción opcional
            $table->timestamps();
            $table->unsignedBigInteger('company_id')->nullable();

            // Clave foránea
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_payments');
    }
};
