<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\PurchaseDueDate;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseDueDateFactory extends Factory
{
    protected $model = PurchaseDueDate::class;

    public function definition(): array
    {
        return [
            'purchase_id' => Purchase::factory(),
            'due_date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}