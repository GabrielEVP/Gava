<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code_number');
            $table->string('registration_number');
            $table->string('legal_name');
            $table->string('type_supplier');
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('municipality')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->integer('credit_day_limit')->nullable();
            $table->decimal('limit_credit', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('supplier_phones', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['landline', 'mobile']);
            $table->string('phone');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references(columns: 'id')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('supplier_emails', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['personal', 'work'])->default('work');
            $table->string('email');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references(columns: 'id')->on('suppliers')->onDelete('cascade');
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