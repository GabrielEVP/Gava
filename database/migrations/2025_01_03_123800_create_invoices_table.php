<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'number');
            $table->date(column: 'date');
            $table->enum(column: 'status', allowed: ['pending', 'paid', 'refused'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('total_tax_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax_rate', 10, 2);
            $table->decimal('total_amount', 10, 2)->generatedAs('quantity * unit_price)');
            $table->decimal('total_tax_amount', 10, 2)->generatedAs('quantity * unit_price * (1 + tax_rate / 100)');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->unsignedBigInteger('type_payment_id');
            $table->foreign('type_payment_id')->references('id')->on('type_payments')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('invoice_due_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'refused'])->default('pending');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
        Schema::dropIfExists('invoice_due_dates');
        Schema::dropIfExists('invoice_lines');
        Schema::dropIfExists('invoices');
    }
};
