<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'number' => '123123',
            'date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
            'supplier_id' => Supplier::factory(),
            'user_id' => User::factory(),
        ];
    }
}
