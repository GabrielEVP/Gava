<?php

namespace Database\Factories;

use App\Models\PurchaseLine;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseLineFactory extends Factory
{
    protected $model = PurchaseLine::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'tax_rate' => $this->faker->randomFloat(2, 0, 25),
            'total_amount' => $this->faker->randomFloat(2, 10, 10000),
            'total_tax_amount' => $this->faker->randomFloat(2, 10, 10000),
            'status' => $this->faker->randomElement(['pending', 'delivered', 'refused']),
            'purchase_id' => Purchase::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
