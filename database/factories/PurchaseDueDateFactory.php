<?php

namespace Database\Factories;

use App\Models\PurchaseDueDate;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseDueDateFactory extends Factory
{
    protected $model = PurchaseDueDate::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'refused']),
            'purchase_id' => Purchase::factory(),
        ];
    }
}
