<?php

namespace Database\Factories;

use App\Models\InvoiceDueDate;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceDueDateFactory extends Factory
{
    protected $model = InvoiceDueDate::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'refused']),
            'invoice_id' => Invoice::factory(),
        ];
    }
}
