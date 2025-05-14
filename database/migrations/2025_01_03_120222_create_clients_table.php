<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('client_events', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->string('reference_table')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
        });

        Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('state');
            $table->string('municipality');
            $table->string('postal_code');
            $table->string('country');
            $table->boolean('is_billing')->default(false);
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('client_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum(column: 'type', allowed: ['Work', 'Personal'])->default('Work');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('client_phones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->enum(column: 'type', allowed: ['Work', 'Personal'])->default('Work');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references(columns: 'id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('client_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_number');
            $table->enum(column: 'type', allowed: ['AH', 'CO', 'OT'])->default('OT');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_bank_accounts');
        Schema::dropIfExists('client_emails');
        Schema::dropIfExists('client_phones');
        Schema::dropIfExists('clientes_addresses');
        Schema::dropIfExists('clients');
    }
};