<?php

namespace Database\Factories;

use App\Models\RecurringInvoiceLine;
use App\Models\RecurringInvoice;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecurringInvoiceLineFactory extends Factory
{
    protected $model = RecurringInvoiceLine::class;

    public function definition(): array
    {
        return [
            'recurring_invoice_id' => RecurringInvoice::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'total_price' => $this->faker->randomFloat(2, 10, 10000),
        ];
    }
}
