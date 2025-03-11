<?php

namespace Database\Factories;

use App\Models\InvoiceLine;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceLineFactory extends Factory
{
    protected $model = InvoiceLine::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'tax_rate' => $this->faker->randomFloat(2, 0, 25),
            'total_amount' => $this->faker->randomFloat(2, 10, 10000),
            'total_amount_rate' => $this->faker->randomFloat(2, 10, 10000),
            'invoice_id' => Invoice::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
