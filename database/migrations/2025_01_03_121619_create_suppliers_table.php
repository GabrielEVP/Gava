<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_name')->unique();
            $table->string('vat_number');
            $table->string('registration_number')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('supplier_phones', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->enum('type', ['landline', 'mobile']);
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('supplier_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum('type', ['personal', 'work'])->default('work');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('supplier_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_type');
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
        Schema::dropIfExists(table: 'suppliers');
    }
};
