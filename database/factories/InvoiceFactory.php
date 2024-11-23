<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->unique()->numerify('INV-#####'),
            'issue_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
            'client_id' => Client::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
