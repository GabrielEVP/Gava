<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->numerify('INV-#####'),
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
            'total_amount' => 203,
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
        ];
    }
}
