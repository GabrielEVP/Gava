<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseLineFactory extends Factory
{
    protected $model = PurchaseLine::class;

    public function definition(): array
    {
        return [
            'concept' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 1, 100),
            'vat_rate' => $this->faker->randomFloat(2, 0, 0.25),
            'total_amount' => $this->faker->randomFloat(2, 1, 1000),
            'total_amount_rate' => $this->faker->randomFloat(2, 1, 1000),
            'product_id' => Product::factory(),
            'purchase_id' => Purchase::factory(),
        ];
    }
}
