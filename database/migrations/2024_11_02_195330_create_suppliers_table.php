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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nombre del proveedor
            $table->string('legal_name'); // Nombre legal del proveedor
            $table->string('vat_number'); // Número de identificación fiscal
            $table->string('registration_number')->nullable(); // Número de registro
            $table->string('email')->nullable(); // Correo electrónico
            $table->string('phone')->nullable(); // Teléfono
            $table->string('website')->nullable(); // Sitio web
            $table->unsignedBigInteger('category_id')->nullable(); // Clave foránea que referencia a supplier_categories
            $table->timestamps();
            $table->unsignedBigInteger('company_id'); // ID de la compañía relacionada
            $table->unsignedBigInteger('supplier_categories_id'); // ID de la categoría del proveedor

            // Claves foráneas
            $table->foreign('category_id')->references('id')->on('supplier_categories')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('supplier_categories_id')->references('id')->on('supplier_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
