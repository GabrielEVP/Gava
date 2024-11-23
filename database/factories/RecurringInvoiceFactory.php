<?php

namespace Database\Factories;

use App\Models\RecurringInvoice;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecurringInvoiceFactory extends Factory
{
    protected $model = RecurringInvoice::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'company_id' => Company::factory(),
            'invoice_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'cancelled']),
            'frequency' => $this->faker->randomElement(['weekly', 'monthly', 'yearly']),
            'next_invoice_date' => $this->faker->date(),
        ];
    }
}
