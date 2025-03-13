<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->string('legal_name');
            $table->enum(column: 'type', allowed: ['NT', 'JU', 'GB', 'OT'])->default('OT');
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->enum(column: 'currency', allowed: ['EUR', 'USD', 'BOV', 'OT'])->default('USD');
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('supplier_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('state');
            $table->string('municipality');
            $table->string('postal_code');
            $table->string('country');
            $table->boolean('is_billing')->default(false);
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('supplier_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum(column: 'type', allowed: ['Work', 'Personal'])->default('Work');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('supplier_phones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->enum(column: 'type', allowed: ['Work', 'Personal'])->default('Work');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references(columns: 'id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('supplier_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_number');
            $table->enum(column: 'type', allowed: ['AH', 'CO', 'OT'])->default('OT');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists(table: 'supplier_bank_accounts');
        Schema::dropIfExists(table: 'supplier_phones');
        Schema::dropIfExists(table: 'supplier_emails');
        Schema::dropIfExists('supplier_addresses');
        Schema::dropIfExists(table: 'suppliers');
    }
};
