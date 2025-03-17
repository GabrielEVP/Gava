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
            'number' => $this->faker->unique()->numerify('PUR-#####'),
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'refused']),
            'total_amount' => $this->faker->randomFloat(2, 0, 20),
            'total_tax_amount' => $this->faker->randomFloat(2, 0, 20),
            'supplier_id' => Supplier::factory(),
            'user_id' => User::factory(),
        ];
    }
}
