<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->timestamp('date');
            $table->enum('status', allowed: ['pending', 'accept', 'refused'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax_rate', 10, 2);
            $table->decimal('total_amount', 10, 2)->generatedAs('quantity * unit_price)');
            $table->decimal('total_amount_rate', 10, 2)->generatedAs('quantity * unit_price * (1 + tax_rate / 100)');
            $table->timestamps();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_lines');
        Schema::dropIfExists('orders');
    }
};
