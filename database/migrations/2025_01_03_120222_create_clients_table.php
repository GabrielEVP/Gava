<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name');
            $table->string('vat_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('currency')->default('USD');
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->integer('payment_terms')->nullable();
            $table->string('contact_person')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('client_phones', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->enum('type', ['landline', 'mobile']);
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('client_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum('type', ['personal', 'work'])->default('work');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('client_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_type');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_bank_accounts');
        Schema::dropIfExists('client_emails');
        Schema::dropIfExists('client_phones');
        Schema::dropIfExists('clients');
    }
};