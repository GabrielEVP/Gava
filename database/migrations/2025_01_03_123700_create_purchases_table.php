<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number');
            $table->string('concept');
            $table->date('date');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('vat_rate', 10, 2);
            $table->decimal('total_amount', 10, 2)->storedAs('quantity * unit_price');
            $table->decimal('total_amount_rate', 10, 2)->storedAs('quantity * unit_price * (1 + vat_rate / 100)');
            $table->timestamps();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });

        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('type_payment_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onDelete('restrict');
        });

        Schema::create('purchase_due_dates', function (Blueprint $table) {
            $table->id();
            $table->timestamp('due_date');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_payments');
        Schema::dropIfExists('purchase_due_dates');
        Schema::dropIfExists('purchase_lines');
        Schema::dropIfExists('purchases');
    }
};
